class ApiFormHandler {
  baseUrl = "/mvc";

  constructor({
    formId,
    endpoint,
    method = "POST",
    data = {},
    onSuccess = null,
    onError = null,
  }) {
    this.formId = formId;
    this.endpoint = endpoint;
    this.method = method;
    this.data = data;
    this.requestUrl = `${this.baseUrl}/${this.endpoint}`;

    this.setup({ onSuccess, onError });
  }

  async sendFormData(formData) {
    try {
      const response = await fetch(this.requestUrl, {
        method: this.method,
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

  async submitForm() {
    const formData = this.getFormDataFromForm();
    const result = await this.sendFormData(formData);

    return result;
  }

  getFormDataFromForm() {
    const formData = new FormData();
    const formElement = this.getFormElement();

    for (const element of formElement.elements) {
      if (element.name) {
        formData.append(element.name, element.value);
      }
    }

    return formData;
  }

  getFormElement() {
    return document.getElementById(this.formId);
  }

  setup({ onSuccess, onError }) {
    const formElement = this.getFormElement();

    formElement.addEventListener("submit", async (event) => {
      event.preventDefault();

      const response = await this.submitForm();

      if (response) {
        onSuccess(JSON.stringify(response));
      } else {
        onError(JSON.stringify(response));
      }
    });
  }
}
