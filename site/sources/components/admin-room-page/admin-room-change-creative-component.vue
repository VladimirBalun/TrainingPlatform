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
        <div class="modal fade" id="change-creative-modal" tabindex="-1" ref="closeButton" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Изменение</h5>
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
                        <label for="creative-description"><label class="require-color">*</label> Введите описание (можно использовать <a href="https://paulradzkov.com/2014/markdown_cheatsheet/">MarkDown разметку</a> вместе с картинками, ссылками и таблицами для улучшения визуальных качеств текста):</label>
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
                        <label v-show="creative.country !== 'Не выбрано'" for="creative-city">Выберите город (если необходимо):</label>
                        <select v-model="creative.city" v-show="creative.country !== 'Не выбрано'" class="model-input" v-bind:class="{ 'error-input': !creativeValidation.city }" id="creative-city">
                            <option>Не выбрано</option>
                            <option v-for="city in citiesModel">{{ city }}</option>
                        </select>
                        <label for="creative-date">Введите дату события (если необходимо):</label>
                        <input v-bind:class="{ 'error-input': !creativeValidation.eventDate }" class="model-input" v-model="creative.eventDate" type="date" id="creative-date">
                        <label for="creative-img">Введите адрес изображения (если необходимо, то на данный момент можно использовать ссылку
                          на изображение только со стороннего ресурса, а также желательно с разрешением 16:9):</label>
                        <input v-model="creative.image" v-bind:class="{ 'error-input': !creativeValidation.image }" class="model-input" type="text" id="creative-img" maxlength="2083">
                        <label for="creative-number">Введите телефон (если необходимо):</label>
                        <input v-model="creative.number" class="model-input" type="text" id="creative-number">
                        <label for="creative-email">Введите e-mail (если необходимо):</label>
                        <input v-model="creative.email" v-bind:class="{ 'error-input': !creativeValidation.email }" class="model-input" type="text" id="creative-email" maxlength="320">
                        <label for="creative-site">Введите адрес сайта (если необходимо):</label>
                        <input v-model="creative.site" v-bind:class="{ 'error-input': !creativeValidation.site }"  class="model-input" type="text" id="creative-site" maxlength="2083">
                        <label for="creative-price"><label class="require-color">*</label> Введите цену (пока что только в рублях):</label>
                        <input v-bind:class="{ 'error-input': !creativeValidation.price }" v-model="creative.price" class="model-input" type="number" id="creative-price">
                        <label for="navigation-type-off-onl"><label class="require-color">*</label> Выберите тип:</label>
                        <p id="navigation-type-off-onl" class="target-label">
                            <label><input value="true" v-model="creative.online" checked type="radio"/></label>Онлайн
                            <label><input value="false" v-model="creative.online" type="radio"/></label>Оффлайн
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-button" data-dismiss="modal">Отмена</button>
                        <button type="button" class="modal-button" v-on:click="changeCreative">Изменить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import _ from "underscore";
    import * as network from "../../scripts/network";
    import * as validation from "../../scripts/validation";

    export default {
        name: "admin-room-change-creative-component",
        props: ["advertiserId"],
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
                initialCreative: {},
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
            showMessageModal(type, title, description) {
                this.$root.$emit("show-message-modal", {
                    type: type,
                    title: title,
                    description: description
                });
            },
            changeCreative() {
                let creativeForm = {
                    creative: this.creative,
                    creativeValidation: this.creativeValidation
                };

                if (_.isMatch(this.initialCreative, this.creative)) {
                    this.$refs.closeButton.click();
                    this.showMessageModal("error", "Ошибка", "Не было внесено никаких правок в объявление для его изменения");
                    return;
                }

                this.errorMessage = validation.validateCreativeForm(creativeForm)
                if (this.errorMessage !== "") {
                    document.getElementById("change-creative-page-modal").scrollTo({ top: 0, behavior: 'smooth' });
                    return;
                }

                const self = this;
                network.changeCreative(this, _.clone(this.creative), (result) => {
                    console.log(result);
                    self.$refs.closeButton.click();
                    if (result.result === 1) {
                        self.showMessageModal("info", "Успешная операция", "Объявление успешно добавлено, оно сразу" +
                            "же появится на сайте, как только пройдет модерацию");
                        self.$root.$emit('changed-creative-page', _.clone(self.creative));
                    } else {
                        self.showMessageModal("error", "Ошибка", "Объявление не было изменено");
                    }
                }, error => {
                    console.log(error);
                    self.$refs.closeButton.click();
                    self.showMessageModal("error", "Ошибка", "Объявление не было изменено");
                });
            },
            fillAllModels() {
                const self = this;
                network.loadMetaInformation(self, meta => {
                    self.countriesModel = meta.countries;
                    self.themesModel = meta.themes;
                    self.categoriesModel = meta.categories;
                }, error => {
                    console.log(error);
                });
            },
            fillCitiesModelBySelectedCountry(event) {
                if (event.target.value === "Не выбрано") {
                    this.citiesModel = ["Не выбрано"];
                    this.creative.city = "Не выбрано";
                } else {
                    const self = this;
                    this.creative.city = "Не выбрано";
                    network.loadCitiesByCountryName(self, event.target.value, cities => {
                        self.citiesModel = cities;
                    }, error => {
                        console.log(error);
                    })
                }
            },
            onChangeCountryModel(event) {
                this.fillCitiesModelBySelectedCountry(event);
            }
        },
        created() {
            this.fillAllModels();

            const self = this;
            this.$root.$on("click-change-creative-page", (creative) => {
                self.creative.id = creative.id;
                self.creative.title = creative.title;
                self.creative.briefDescription = creative.briefDescription;
                self.creative.description = creative.description;
                self.creative.image = creative.imageURL;
                self.creative.eventDate = creative.eventDate;
                self.creative.price = creative.price;
                self.creative.email = creative.advertiserEmail;
                self.creative.phone = creative.advertiserPhone;
                self.creative.site = creative.advertiserSite;
                self.creative.category = creative.category;
                self.creative.theme = creative.theme;
                self.creative.online = creative.online;
                if (creative.city !== null) {
                    self.creative.city = creative.city;
                }
                if (creative.country !== null) {
                    self.creative.country = creative.country;
                }
                self.initialCreative = _.clone(self.creative);
            });
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
        background-color: #ffcccb;
        margin-bottom: 15px;
        border-radius: 5px;
        color: #c41e3a;
        text-align: center;
        font-family: 'Open Sans', sans-serif;
        font-size: 15px;
        padding: 20px;
    }

</style>