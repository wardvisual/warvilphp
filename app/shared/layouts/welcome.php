<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'WarvilPHP Framework') ?></title>
    
    <!-- Meta -->
    <meta name="description" content="A lightweight PHP framework inspired by Laravel">
    <meta name="author" content="WardVisual">
    
    <!-- Tailwind CSS from CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Pulse animation for the logo */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }
        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #4f46e5;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #6366f1;
        }
        
        /* Code block styling */
        pre {
            border-radius: 0.375rem;
            padding: 1rem;
            overflow-x: auto;
        }
    </style>
</head>
<body class="bg-gray-900 text-white antialiased">
    <!-- Page Content -->
    <?= $this->content ?? '' ?>
    
    <!-- Optional JavaScript -->
    <script>
        // Add any JavaScript needed for the welcome page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('WarvilPHP - Welcome!');
            
            // Add subtle animation to feature boxes on hover
            const featureBoxes = document.querySelectorAll('.bg-gray-800');
            featureBoxes.forEach(box => {
                box.addEventListener('mouseenter', () => {
                    box.classList.add('transform', 'scale-105', 'transition-all');
                });
                box.addEventListener('mouseleave', () => {
                    box.classList.remove('transform', 'scale-105');
                });
            });
        });
    </script>
</body>
</html>