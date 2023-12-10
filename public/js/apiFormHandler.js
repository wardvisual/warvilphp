class ApiFormHandler {
  baseUrl = "/mvc";

  constructor({ formId, url, method = "POST", data = {}, actions = {} }) {
    this.formId = formId;
    this.url = url;
    this.method = method;
    this.data = data;
    this.requestUrl = `${this.baseUrl}/${this.url}`;

    this.setup(actions);
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

  setup(action) {
    const formElement = this.getFormElement();

    formElement.addEventListener("submit", async (event) => {
      event.preventDefault();

      const response = await this.submitForm();

      if (response) {
        action.onSuccess(JSON.stringify(response));
      } else {
        action.onError(JSON.stringify(response));
      }
    });
  }
}
