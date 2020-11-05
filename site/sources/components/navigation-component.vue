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
    <div class="navigation-wrapper">
        <div class="navigation block">
            <p class="navigation-title">Фильтры</p>
            <label for="navigation-categoty">Категория:</label>
            <select id="navigation-categoty">
                <option>Не выбрано</option>
                <option v-for="category in categoriesModel">{{ category }}</option>
            </select>
            <label for="navigation-type">Тематика:</label>
            <select id="navigation-type">
                <option>Не выбрано</option>
                <option v-for="theme in themesModel">{{ theme }}</option>
            </select>
            <label for="navigation-country">Страна:</label>
            <select v-model="selectedCountryModel" @change="onChangeCountryModel($event)" id="navigation-country">
                <option>Не выбрано</option>
                <option v-for="country in countriesModel">{{ country }}</option>
            </select>
            <label for="navigation-city">Город:</label>
            <select v-model="selectedCityModel" :disabled="selectedCountryModel === 'Не выбрано'" id="navigation-city">
                <option>Не выбрано</option>
                <option v-for="city in citiesModel">{{ city }}</option>
            </select>
            <label for="navigation-type-off-onl">Тип:</label>
            <p id="navigation-type-off-onl" class="target-label">
                <label><input name="dzen" type="radio"/></label>Онлайн
                <label><input name="dzen" type="radio"/></label>Оффлайн
            </p>
            <label for="navigation-sort">Сортировка:</label>
            <select id="navigation-sort">
                <option>Не выбрано</option>
                <option>По дате</option>
                <option>По цене</option>
                <option>По названию</option>
            </select>
            <p class="target-label">
                <label><input name="sort" type="radio"/></label>Возрастание
                <label><input name="sort" type="radio"/></label>Убывание
            </p>
            <label>Цена от:</label>
            <input v-model="priceFromModel" :disabled="isFreeModel" type="number">
            <label>Цена до:</label>
            <input v-model="priceToModel" :disabled="isFreeModel" type="number">
            <label class="target-label">Бесплатные:</label>
            <input v-model="isFreeModel" type="checkbox">
            <div class="wrapper">
                <button class="navigation-button">Искать</button>
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";

    export default {
        name: "navigation-component",
        data() {
            return {
                categoriesModel: [],
                themesModel: [],
                countriesModel: [],
                selectedCountryModel: "Не выбрано",
                citiesModel: [],
                selectedCityModel: "Не выбрано",
                priceFromModel: 0,
                priceToModel: 100000,
                isFreeModel: false
            };
        },
        methods: {
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
                    this.selectedCityModel = "Не выбрано";
                } else {
                    const self = this;
                    this.$http.get("http://localhost:8080/cities", { params: { country_name: event.target.value } })
                        .then(response => {
                            self.citiesModel = response.body;
                        });
                }
            },

            onChangeCountryModel(event) {
                this.fillCitiesModelBySelectedCountry(event);
            },
            onFindButtonClick() {
            }
        },
        created() {
            this.fillAllModels();
        }
    }

</script>

<style scoped>

    hr {
        background-color: #CCCCCC;
        padding: 0 20px 0 20px;
    }

    label {
        font-weight: normal;
        font-family: 'Open Sans', sans-serif;
        font-size: 14px;
        margin-left: 20px;
        color: #666666;
    }

    .navigation-wrapper {
        position: relative;
        height: 2000px;
    }

    .navigation {
        background-color: white;
        border-radius: 5px;
    }

    select {
        border: 1px solid #666666;
        color: black;
        display: block;
        width: calc(100% - 40px);
        padding: 5px 10px 5px 10px;
        border-radius: 5px;
        font-size: 16px;
        margin: 0 20px 10px 20px;
        font-family: 'Open Sans', sans-serif;
    }

    input[type="number"] {
       border: 1px solid #666666;
        display: block;
        margin: 0 20px 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        padding: 6px 10px 6px 10px;
        font-family: 'Open Sans', sans-serif;
        width: calc(100% - 40px);
    }

    .target-label {
        color: black;
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
    }

    .navigation-title {
        color: black;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 20px;
        padding: 20px 20px 10px 20px;
    }

    .navigation-button {
        position: relative;
        width: calc(100% - 40px);
        margin: 20px;
        font-size: 16px;
        background-color: #2D71BC;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 6px 10px 6px 10px;
        font-family: 'Open Sans', sans-serif;
    }

</style>