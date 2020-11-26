<!--
- Copyright 2018 Vladimir Balun
-
- Licensed under the Apache License, Version 2.0 (the "License");
- you may not use this file except in compliance with the License.
- You may obtain a copy of the License at
-
-     http://www.apache.org/licenses/LICENSE-2.0
-
- Unless required by applicable law or agreed to in writing, software
- distributed under the License is distributed on an "AS IS" BASIS,
- WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
- See the License for the specific language governing permissions and
- limitations under the License.
-->

<template>
    <div>
        <div class="modal fade" id="add-creative-modal" tabindex="-1" ref="closeButton" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Добавление</h5>
                        <button type="button" class="modal-close-button" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-window-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-show="errorMessage !== ''" class="error-block col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            {{ errorMessage }}
                        </div>
                        <label for="creative-title"><label class="require-color">*</label> Введите название:</label>
                        <input class="model-input" v-model="creative.title" v-bind:class="{ 'error-input': !creativeValidation.title }" type="text" id="creative-title">
                        <label for="creative-brief-description"><label class="require-color">*</label> Введите краткое описание:</label>
                        <textarea class="model-input" v-model="creative.briefDescription" v-bind:class="{ 'error-input': !creativeValidation.briefDescription }" id="creative-brief-description"/>
                        <label for="creative-description"><label class="require-color">*</label> Введите описание:</label>
                        <textarea class="model-input" v-model="creative.description" v-bind:class="{ 'error-input': !creativeValidation.description }" id="creative-description"/>
                        <label for="creative-category"><label class="require-color">*</label> Выберите категорию:</label>
                        <select v-model="creative.category" class="model-input" v-bind:class="{ 'error-input': !creativeValidation.category }" id="creative-category">
                            <option>Не выбрано</option>
                            <option v-for="category in categoriesModel">{{ category }}</option>
                        </select>
                        <label for="creative-type"><label class="require-color">*</label> Выберите тематику:</label>
                        <select v-model="creative.theme" class="model-input" v-bind:class="{ 'error-input': !creativeValidation.theme }" id="creative-type">
                            <option>Не выбрано</option>
                            <option v-for="theme in themesModel">{{ theme }}</option>
                        </select>
                        <label for="creative-country">Выберите страну (если необходимо):</label>
                        <select v-model="creative.country" @change="onChangeCountryModel($event)" class="model-input" v-bind:class="{ 'error-input': !creativeValidation.country }" id="creative-country">
                            <option>Не выбрано</option>
                            <option v-for="country in countriesModel">{{ country }}</option>
                        </select>
                        <label for="creative-city">Выберите город (если необходимо):</label>
                        <select v-model="creative.city" v-show="creative.country !== 'Не выбрано'" class="model-input" v-bind:class="{ 'error-input': !creativeValidation.city }" id="creative-city">
                            <option>Не выбрано</option>
                            <option v-for="city in citiesModel">{{ city }}</option>
                        </select>
                        <label for="creative-date">Введите дату события (если необходимо):</label>
                        <input v-bind:class="{ 'error-input': !creativeValidation.eventDate }" class="model-input" v-model="creative.eventDate" type="date" id="creative-date">
                        <label for="creative-img">Введите адрес изображения (если необходимо, то на данный момент можно использовать ссылку
                          на изображение только со стороннего ресурса):</label>
                        <input v-model="creative.image" v-bind:class="{ 'error-input': !creativeValidation.image }" class="model-input" type="text" id="creative-img">
                        <label for="creative-number">Введите телефон (если необходимо):</label>
                        <input v-model="creative.number" class="model-input" type="text" id="creative-number">
                        <label for="creative-email">Введите e-mail (если необходимо):</label>
                        <input v-model="creative.email" v-bind:class="{ 'error-input': !creativeValidation.email }" class="model-input" type="text" id="creative-email">
                        <label for="creative-site">Введите адрес сайта (если необходимо):</label>
                        <input v-model="creative.site" v-bind:class="{ 'error-input': !creativeValidation.site }"  class="model-input" type="text" id="creative-site">
                        <label for="creative-price"><label class="require-color">*</label> Введите цену:</label>
                        <label for="creative-price"><label class="require-color">*</label> Введите цену:</label>
                        <input v-bind:class="{ 'error-input': !creativeValidation.price }" v-model="creative.price" class="model-input" type="number" id="creative-price">
                        <label for="navigation-type-off-onl"><label class="require-color">*</label> Выберите тип:</label>
                        <p id="navigation-type-off-onl" class="target-label">
                            <label><input value="true" v-model="creative.online" checked type="radio"/></label>Онлайн
                            <label><input value="false" v-model="creative.online" type="radio"/></label>Оффлайн
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-button" data-dismiss="modal">Отмена</button>
                        <button type="button" class="modal-button" v-on:click="addCreative">Добавить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "admin-room-add-creative-component",
        data() {
            return {
                errorMessage: "",
                creative: {
                    id: 0,
                    title: "",
                    briefDescription: "",
                    description: "",
                    category: "Не выбрано",
                    theme: "Не выбрано",
                    country: "Не выбрано",
                    city: "Не выбрано",
                    eventDate: "",
                    image: "",
                    email: "",
                    site: "",
                    number: "",
                    price: 0,
                    online: true
                },
                creativeValidation: {
                    title: true,
                    briefDescription: true,
                    description: true,
                    category: true,
                    theme: true,
                    country: true,
                    city: true,
                    eventDate: true,
                    price: true,
                    image: true,
                    email: true,
                    site: true
                },
                categoriesModel: [],
                themesModel: [],
                countriesModel: [],
                citiesModel: [],
            };
        },
        methods: {
            checkFormOnEmpty() {
                if (this.creative.title !== "") {
                    this.creativeValidation.title = true;
                } else {
                    this.creativeValidation.title = false;
                    this.errorMessage = "Название объявления не может быть пустым";
                    return false;
                }
                if (this.creative.briefDescription !== "") {
                    this.creativeValidation.briefDescription = true;
                } else {
                    this.creativeValidation.briefDescription = false;
                    this.errorMessage = "Краткое описание объявления не может быть пустым";
                    return false;
                }
                if (this.creative.description !== "") {
                    this.creativeValidation.description = true;
                } else {
                    this.creativeValidation.description = false;
                    this.errorMessage = "Описание объявления не может быть пустым";
                    return false;
                }
                if (this.creative.category !== "Не выбрано") {
                    this.creativeValidation.category = true;
                } else {
                    this.creativeValidation.category = false;
                    this.errorMessage = "Необходимо выбрать категорию";
                    return false;
                }
                if (this.creative.theme !== "Не выбрано") {
                    this.creativeValidation.theme = true;
                } else {
                    this.creativeValidation.theme = false;
                    this.errorMessage = "Необходимо выбрать тему";
                    return false;
                }
                if (this.creative.price !== "") {
                    this.creativeValidation.price = true;
                } else {
                    this.creativeValidation.price = false;
                    this.errorMessage = "Необходимо ввести цену, если услуга бесплатная - нужно указать ноль";
                    return false;
                }

                return true;
            },
            checkFormValidation() {
                if (this.creative.eventDate !== "") {
                    if ((new Date()) > (new Date(this.creative.eventDate))) {
                        this.creativeValidation.eventDate = false;
                        this.errorMessage = "Невозможно указать дату события в прошлом";
                        return false;
                    }
                }
                if (this.creative.email !== "") {
                    const regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
                    if (!regex.test(this.creative.email)) {
                        this.creativeValidation.email = false;
                        this.errorMessage = "Некорректный e-mail адрес";
                        return false;
                    }
                }
                if (this.creative.image !== "") {
                    const regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
                    if (!regex.test(this.creative.image)) {
                        this.creativeValidation.image = false;
                        this.errorMessage = "Некорректный адрес изображения";
                        return false;
                    }
                }
                if (this.creative.site !== "") {
                    const regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
                    if (!regex.test(this.creative.site)) {
                        this.creativeValidation.site = false;
                        this.errorMessage = "Некорректный адрес сайта";
                        return false;
                    }
                }

                return true;
            },
            addCreative() {
                this.errorMessage = "";
                this.creativeValidation.city = true;
                this.creativeValidation.briefDescription = true;
                this.creativeValidation.description = true;
                this.creativeValidation.category = true;
                this.creativeValidation.eventDate = true;
                this.creativeValidation.theme = true;
                this.creativeValidation.price = true;
                this.creativeValidation.image = true;
                this.creativeValidation.email = true;
                this.creativeValidation.site = true;


                if (!this.checkFormOnEmpty()) {
                    document.getElementById("add-creative-modal").scrollTo({ top: 0, behavior: 'smooth' });
                }
                if (!this.checkFormValidation()) {
                    document.getElementById("add-creative-modal").scrollTo({ top: 0, behavior: 'smooth' });
                }

                const creativeResponse = this.creative;
                if (creativeResponse.country === "Не выбрано") {
                    creativeResponse.country = null
                }
                if (creativeResponse.city === "Не выбрано") {
                    creativeResponse.city = null;
                }
                if (creativeResponse.eventDate === "") {
                    creativeResponse.eventDate = null;
                }
                if (creativeResponse.email === "") {
                    creativeResponse.email = null;
                }
                if (creativeResponse.number === "") {
                    creativeResponse.number = null;
                }
                if (creativeResponse.site === "") {
                    creativeResponse.site = null;
                }

                this.$http.post("http://localhost:8080/add_creative", { creative: creativeResponse })
                    .then(response => {
                        console.log(response);
                    });
            },
            fillAllModels() {
                const self = this;
                this.$http.get("http://localhost:8080/meta")
                    .then(response => {
                        self.countriesModel = response.body.countries;
                        self.themesModel = response.body.themes;
                        self.categoriesModel = response.body.categories;
                    });
            },
            fillCitiesModelBySelectedCountry(event) {
                if (event.target.value === "Не выбрано") {
                    this.citiesModel = ["Не выбрано"];
                    this.creative.city = "Не выбрано";
                } else {
                    const self = this;
                    this.creative.city = "Не выбрано";
                    this.$http.get("http://localhost:8080/cities", { params: { country_name: event.target.value } })
                        .then(response => {
                            self.citiesModel = response.body;
                        });
                }
            },
            onChangeCountryModel(event) {
                this.fillCitiesModelBySelectedCountry(event);
            }
        },
        created() {
            this.fillAllModels();
        }
    }

</script>

<style scoped>

    .modal-close-button {
        border: none;
        padding: 0;
        outline: none;
        background-color: transparent;
        color: #10367B;
        font-size: 25px;
        float: right;
    }

    .modal-title {
        float: left;
        font-size: 21px;
        padding-top: 2px;
        font-family: 'Roboto', sans-serif;
    }

    label {
        font-weight: normal;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        color: #666666;
    }

    input[type="radio"] {
        padding: 5px;
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
        border: 1px solid #439EDC;
    }

    .model-input {
        border: 1px solid #439EDC;
        display: block;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 16px;
        padding: 10px 15px 10px 15px;
        font-family: 'Open Sans', sans-serif;
        width: 100%;
        margin-bottom: 15px;
    }

    select {
        border: 1px solid #439EDC;
        background-color: #EEF3F8;
        color: black;
        display: block;
        width: 100%;
        padding: 10px 15px 10px 15px;
        border-radius: 5px;
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
        margin-bottom: 15px;
    }

    textarea {
        resize: vertical;
        min-height: 100px;
    }

    .modal-button {
        border: 1px solid white;
        outline: none;
        padding: 7px 21px 7px 21px;
        border-radius: 5px;
        font-size: 14px;
        font-family: 'Open Sans', sans-serif;
        color: white;
        background-color: transparent;
        transition: .3s;
    }

    .modal-button:hover {
        border: 1px solid #439EDC;
        color: #439EDC;
    }

    .modal-footer {
        padding-top: 15px;
        background-color: #10367B;
    }

    .require-color {
        color: #d92626;
    }

    .error-input {
        border: 2px solid #d92626;
        background-color: #ffe6e6;
    }

    .error-block {
        background-color: #8f1c2a;
        margin-bottom: 15px;
        border-radius: 5px;
        color: white;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 15px;
        padding: 20px;
    }

</style>