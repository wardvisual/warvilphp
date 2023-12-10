class ApiFormHandler {
  baseUrl = "/mvc";
  requestUrl = "";

  constructor({ formId, endpoint, onSuccess = null, onError = null }) {
    this.formId = formId;
    this.endpoint = endpoint;
    this.requestUrl = `${this.baseUrl}/${this.endpoint}`;

    this.setup();
  }

  async sendFormData(formData) {
    try {
      const response = await fetch(this.requestUrl, {
        method: "POST",
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
    try {
      const formData = this.getFormDataFromForm();
      const result = await this.sendFormData(formData);

      console.log(result);
    } catch (error) {
      console.error({ error });
    }
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

  setup() {
    const formElement = this.getFormElement();

    formElement.addEventListener("submit", (event) => {
      event.preventDefault();
      this.submitForm();
    });
  }
}
