<?php
/**
 * WarvilPHP Release Helper
 * 
 * This script automates the release process for WarvilPHP by updating version numbers,
 * creating git tags, and pushing releases to GitHub.
 */

// Check if this is a help command
if (isset($argv[1]) && ($argv[1] === 'help' || $argv[1] === '--help' || $argv[1] === '-h')) {
    showHelp();
    exit(0);
}

// Show help if no arguments provided
if (!isset($argv[1])) {
    showHelp();
    exit(1);
}

// Configuration
$composerFile = 'composer.json';
$warvilFile = 'warvil.json';
$branch = 'main'; // Default branch for releases

// Parse command line arguments
$args = array_slice($argv, 1);

// Parse version increment type
$type = $args[0];
if (!in_array($type, ['major', 'minor', 'patch'])) {
    echo "Error: Invalid version increment type. Use 'major', 'minor', or 'patch'.\n";
    exit(1);
}

// Check for version suffix
$suffix = '';
if (in_array('--alpha', $args)) {
    $suffix = '-alpha';
} elseif (in_array('--beta', $args)) {
    $suffix = '-beta';
} elseif (in_array('--rc', $args)) {
    $suffix = '-rc';
}

// Check for push flag
$noPush = in_array('--no-push', $args);

// Read composer.json
if (!file_exists($composerFile)) {
    echo "Error: {$composerFile} not found.\n";
    exit(1);
}
$composer = json_decode(file_get_contents($composerFile), true);
if (!isset($composer['version'])) {
    echo "Error: Version not found in {$composerFile}.\n";
    exit(1);
}

// Read warvil.json
$warvil = null;
if (file_exists($warvilFile)) {
    $warvil = json_decode(file_get_contents($warvilFile), true);
    if (!isset($warvil['version'])) {
        echo "Warning: Version not found in {$warvilFile}. It will be added.\n";
        $warvil['version'] = $composer['version'];
    }
}

// Parse current version
$currentVersion = $composer['version'];
echo "Current version: {$currentVersion}\n";

// Strip any suffix from current version
$currentVersion = preg_replace('/-.*$/', '', $currentVersion);

// Calculate new version
$versionParts = explode('.', $currentVersion);
if (count($versionParts) !== 3) {
    echo "Error: Invalid version format. Expected 'x.y.z'.\n";
    exit(1);
}

$major = (int)$versionParts[0];
$minor = (int)$versionParts[1];
$patch = (int)$versionParts[2];

switch ($type) {
    case 'major':
        $major++;
        $minor = 0;
        $patch = 0;
        break;
    case 'minor':
        $minor++;
        $patch = 0;
        break;
    case 'patch':
        $patch++;
        break;
}

$newVersion = "{$major}.{$minor}.{$patch}{$suffix}";
echo "New version: {$newVersion}\n";

// Update composer.json
$composer['version'] = $newVersion;
file_put_contents($composerFile, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
echo "Updated {$composerFile}\n";

// Update warvil.json if it exists
if ($warvil) {
    $warvil['version'] = $newVersion;
    file_put_contents($warvilFile, json_encode($warvil, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n");
    echo "Updated {$warvilFile}\n";
}

// Add changes and commit
$commitMessage = "chore: bump version to {$newVersion}";
echo "Adding files to git...\n";
exec('git add ' . escapeshellarg($composerFile) . ' ' . (file_exists($warvilFile) ? escapeshellarg($warvilFile) : ''), $output, $returnCode);
if ($returnCode !== 0) {
    echo "Error: Failed to add files to git.\n";
    exit(1);
}

echo "Committing changes...\n";
exec('git commit -m ' . escapeshellarg($commitMessage), $output, $returnCode);
if ($returnCode !== 0) {
    echo "Error: Failed to commit changes.\n";
    exit(1);
}

// Create tag
echo "Creating tag {$newVersion}...\n";
$tagMessage = $suffix ? "WarvilPHP {$newVersion} release" : "WarvilPHP {$newVersion} release";
exec('git tag -a ' . escapeshellarg($newVersion) . ' -m ' . escapeshellarg($tagMessage), $output, $returnCode);
if ($returnCode !== 0) {
    echo "Error: Failed to create tag.\n";
    exit(1);
}

// Push changes if not disabled
if (!$noPush) {
    echo "Pushing commits to origin/{$branch}...\n";
    exec("git push origin {$branch}", $output, $returnCode);
    if ($returnCode !== 0) {
        echo "Error: Failed to push commits.\n";
        exit(1);
    }

    echo "Pushing tag {$newVersion}...\n";
    exec('git push origin ' . escapeshellarg($newVersion), $output, $returnCode);
    if ($returnCode !== 0) {
        echo "Error: Failed to push tag.\n";
        exit(1);
    }

    // Create GitHub release if gh CLI is available
    if (commandExists('gh')) {
        $isPrerelease = $suffix ? '--prerelease' : '';
        $releaseTitle = "WarvilPHP {$newVersion}";
        
        // Create template release notes
        $notes = "# WarvilPHP {$newVersion}\n\n";
        
        if ($suffix === '-alpha') {
            $notes .= "This is an alpha release of the WarvilPHP framework.\n\n";
            $notes .= "## Changes\n\n- [List changes here]\n\n";
            $notes .= "## Known Issues\n\n- [List known issues here]\n";
        } elseif ($suffix === '-beta') {
            $notes .= "This is a beta release of the WarvilPHP framework.\n\n";
            $notes .= "## Changes\n\n- [List changes here]\n\n";
            $notes .= "## Known Issues\n\n- [List known issues here]\n";
        } elseif ($suffix === '-rc') {
            $notes .= "This is a release candidate of the WarvilPHP framework.\n\n";
            $notes .= "## Changes\n\n- [List changes here]\n\n";
            $notes .= "## Known Issues\n\n- [List known issues here]\n";
        } else {
            $notes .= "This is a stable release of the WarvilPHP framework.\n\n";
            $notes .= "## Changes\n\n- [List changes here]\n\n";
        }
        
        // Write release notes to a temporary file
        $notesFile = tempnam(sys_get_temp_dir(), 'warvilrelease');
        file_put_contents($notesFile, $notes);
        
        echo "Creating GitHub release...\n";
        $command = "gh release create {$newVersion} --title " . escapeshellarg($releaseTitle) . " --notes-file " . escapeshellarg($notesFile) . " {$isPrerelease}";
        exec($command, $output, $returnCode);
        
        // Clean up temporary file
        unlink($notesFile);
        
        if ($returnCode !== 0) {
            echo "Warning: Failed to create GitHub release. You can create it manually.\n";
        } else {
            echo "GitHub release created successfully!\n";
        }
    } else {
        echo "GitHub CLI not found. You can create a release manually on GitHub.\n";
    }
}

echo "Release {$newVersion} completed successfully!\n";

/**
 * Show help message
 */
function showHelp() {
    $green = "\033[0;32m";
    $yellow = "\033[1;33m";
    $blue = "\033[0;34m";
    $reset = "\033[0m";

    echo <<<EOT
{$green}WarvilPHP Release Helper{$reset}

{$yellow}Usage:{$reset}
  php release.php [major|minor|patch] [options]

{$yellow}Options:{$reset}
  {$blue}major{$reset}            Increment major version (x.0.0)
  {$blue}minor{$reset}            Increment minor version (0.x.0)
  {$blue}patch{$reset}            Increment patch version (0.0.x)
  {$blue}--alpha{$reset}          Create alpha release (e.g. 0.2.0-alpha)
  {$blue}--beta{$reset}           Create beta release (e.g. 0.2.0-beta)
  {$blue}--rc{$reset}             Create release candidate (e.g. 0.2.0-rc)
  {$blue}--no-push{$reset}        Don't push changes to remote repository
  {$blue}help, --help, -h{$reset} Show this help message

{$yellow}Examples:{$reset}
  {$green}php release.php patch{$reset}         # Increment patch version (e.g. 0.1.0 → 0.1.1)
  {$green}php release.php minor{$reset}         # Increment minor version (e.g. 0.1.0 → 0.2.0)
  {$green}php release.php major{$reset}         # Increment major version (e.g. 0.1.0 → 1.0.0)
  {$green}php release.php minor --alpha{$reset} # Create alpha release (e.g. 0.2.0-alpha)

{$yellow}Using with Composer:{$reset}
  {$green}composer release:patch{$reset}
  {$green}composer release:minor{$reset}
  {$green}composer release:major{$reset}
  {$green}composer release:help{$reset}

EOT;
}

/**
 * Check if a command exists
 * 
 * @param string $command Command to check
 * @return bool True if command exists
 */
function commandExists($command) {
    $whereIsCommand = (PHP_OS == 'WINNT') ? 'where' : 'which';
    $process = proc_open(
        "$whereIsCommand $command",
        [
            0 => ["pipe", "r"],
            1 => ["pipe", "w"],
            2 => ["pipe", "w"],
        ],
        $pipes
    );
    
    if (is_resource($process)) {
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $returnCode = proc_close($process);
        return $returnCode === 0;
    }
    
    return false;
}