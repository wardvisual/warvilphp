function createFormApi({
  formId,
  url,
  method = "POST",
  data = {},
  actions = {},
}) {
  const baseUrl = "/mvc";
  const requestUrl = `${baseUrl}/${url}`;

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
    const formData = getFormDataFromForm();
    const result = await sendFormData(formData);
    return result;
  }

  function getFormDataFromForm() {
    const formData = new FormData();
    const formElement = getFormElement();

    for (const element of formElement.elements) {
      if (element.name) {
        formData.append(element.name, element.value);
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

  function listen(action) {
    const formElement = getFormElement();

    formElement.addEventListener("submit", async (event) => {
      event.preventDefault();

      const response = await submitForm();

      if (response) {
        action.onSuccess(JSON.stringify(response));
      } else {
        action.onError(JSON.stringify(response));
      }
    });
  }

  listen(actions);
}
