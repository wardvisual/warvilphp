function apiFormRequest({
  formId,
  url,
  method = "POST",
  data = {},
  actions = {},
}) {
  const origin = window.location.origin;
  const pathname = window.location.pathname;
  const requestUrl = `${pathname}${url}`;

  async function sendFormData(formData) {
    try {
      const response = await fetch(requestUrl, {
        method: method,
        body: formData,
      });

      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }

      return await response.json();
    } catch (error) {
      return error;
    }
  }

  async function submitForm() {
    const formData = getFormData();
    const result = await sendFormData(formData);
    return result;
  }

  function getFormData() {
    const formData = new FormData();
    const formElement = getFormElement();

    for (const element of formElement.elements) {
      if (element.name) {
        if (element.type === "file") {
          for (let i = 0; i < element.files.length; i++) {
            formData.append(element.name, element.files[i]);
          }
        } else {
          formData.append(element.name, element.value);
        }
      }
    }

    return formData;
  }

  function getFormElement() {
    if (formId) {
      return document.getElementById(formId);
    } else {
      return document.querySelector("form");
    }
  }

  function clearForm() {
    const formElement = getFormElement();
    formElement.reset();

    for (const element of formElement.elements) {
      if (element.name) {
        element.value = "";
      }
    }
  }

  function listen(action) {
    const formElement = getFormElement();

    formElement.addEventListener("submit", async (event) => {
      event.preventDefault();

      const response = await submitForm();

      if (response) {
        clearForm();
        action.onSuccess(JSON.stringify(response));
      } else {
        action.onError(JSON.stringify(response));
      }
    });
  }

  listen(actions);
}
