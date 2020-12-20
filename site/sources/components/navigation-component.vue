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
        <search-component></search-component>
        <div class="navigation block hidden-xs">
            <p class="navigation-title"><i class="fas fa-filter"></i>Фильтры</p><hr>
            <label for="navigation-categoty">Категория:</label>
            <select v-model="selectedCategoryModel" id="navigation-categoty">
                <option>Не выбрано</option>
                <option v-for="category in categoriesModel">{{ category }}</option>
            </select>
            <label for="navigation-type">Тематика:</label>
            <select v-model="selectedThemeModel" id="navigation-type">
                <option>Не выбрано</option>
                <option v-for="theme in themesModel">{{ theme }}</option>
            </select><hr>
            <label for="navigation-country">Страна:</label>
            <select v-model="selectedCountryModel" @change="onChangeCountryModel($event)" id="navigation-country">
                <option>Не выбрано</option>
                <option v-for="country in countriesModel">{{ country }}</option>
            </select>
            <div v-show="selectedCountryModel !== 'Не выбрано'">
                <label for="navigation-city">Город:</label>
                <select v-model="selectedCityModel" id="navigation-city">
                    <option>Не выбрано</option>
                    <option v-for="city in citiesModel">{{ city }}</option>
                </select>
            </div><hr>
            <label for="navigation-type-off-onl">Тип:</label>
            <select v-model="selectedType" id="navigation-type-off-onl">
                <option>Не выбрано</option>
                <option>Online</option>
                <option>Offline</option>
            </select>
            <label for="navigation-sort">Сортировка:</label>
            <select v-model="selectedSorting" id="navigation-sort">
                <option>Не выбрано</option>
                <option>По дате (возрастание)</option>
                <option>По дате (убывание)</option>
                <option>По цене (возрастание)</option>
                <option>По цене (убывание)</option>
                <option>По названию (возрастание)</option>
                <option>По названию (убывание)</option>
            </select><hr>
            <div class="price-wrapper">
                <label>Цена от:</label>
                <input v-model="priceFromModel" type="number" min="0" max="1000000">
            </div>
            <div class="price-wrapper">
                <label>Цена до:</label>
                <input v-model="priceToModel" type="number" min="0" max="1000000">
            </div><hr>
            <div class="wrapper">
                <button @click="onFilterButtonClick" class="navigation-button">Применить</button>
            </div>
        </div>
        <advertisement-component class="hidden-xs"></advertisement-component>
    </div>
</template>

<script>

    "use strict";

    import * as network from "../scripts/network";
    import * as protocol from "../scripts/protocol";

    import searchComponent from "../components/search-component";
    import advertisementComponent from "../components/advertisement-component";

    export default {
        name: "navigation-component",
        components: {
            searchComponent,
            advertisementComponent
        },
        data() {
            return {
                searchCreativesPatternModel: "",
                categoriesModel: [],
                selectedCategoryModel: "Не выбрано",
                themesModel: [],
                selectedThemeModel: "Не выбрано",
                countriesModel: [],
                selectedCountryModel: "Не выбрано",
                citiesModel: [],
                selectedCityModel: "Не выбрано",
                selectedType: "Не выбрано",
                selectedSorting: "Не выбрано",
                priceFromModel: 0,
                priceToModel: 1000000,
            };
        },
        methods: {
            fillAllModels() {
              const self = this;
              network.loadMetaInformation(this, response => {
                  console.log(response);
                  if (response instanceof Object) {
                      self.countriesModel = response.countries;
                      self.themesModel = response.themes;
                      self.categoriesModel = response.categories;
                  }
              }, error => {

              })
            },
            fillCitiesModelBySelectedCountry(event) {
                if (event.target.value === "Не выбрано") {
                    this.citiesModel = ["Не выбрано"];
                    this.selectedCityModel = "Не выбрано";
                } else {
                    const self = this;
                    this.selectedCityModel = "Не выбрано";
                    network.loadCitiesByCountryName(this, event.target.value, response => {
                        console.log(response);
                        self.citiesModel = response;
                    }, error => {

                    });
                }
            },
            onChangeCountryModel(event) {
                this.fillCitiesModelBySelectedCountry(event);
            },
            onFilterButtonClick() {
                const filter = {}
                filter.price_from = parseInt(this.priceFromModel);
                filter.price_to = parseInt(this.priceToModel);
                console.log(filter);

                if (this.selectedCategoryModel !== "Не выбрано") {
                    filter.category = this.selectedCategoryModel;
                }
                if (this.selectedThemeModel !== "Не выбрано") {
                    filter.theme = this.selectedThemeModel;
                }
                if (this.selectedCountryModel !== "Не выбрано") {
                    filter.country = this.selectedCountryModel;
                }
                if (this.selectedCityModel !== "Не выбрано") {
                    filter.city = this.selectedCityModel;
                }

                if (this.selectedType === "Online") {
                    filter.type = protocol.FILTER_ONLINE;
                } else if (this.selectedType === "Offline") {
                    filter.type = protocol.FILTER_OFFLINE;
                }

                if (this.selectedSorting === "По дате (возрастание)") {
                    filter.sorting = protocol.SORTING_BY_DATE_ASC;
                } else if (this.selectedSorting === "По дате (убывание)") {
                    filter.sorting = protocol.SORTING_BY_DATE_DESC;
                } else if (this.selectedSorting === "По цене (возрастание)") {
                    filter.sorting = protocol.SORTING_BY_PRICE_ASC;
                } else if (this.selectedSorting === "По цене (убывание)") {
                    filter.sorting = protocol.SORTING_BY_PRICE_DESC;
                } else if (this.selectedSorting === "По названию (возрастание)") {
                    filter.sorting = protocol.SORTING_BY_NAME_ASC;
                } else if (this.selectedSorting === "По названию (убывание)") {
                    filter.sorting = protocol.SORTING_BY_NAME_DESC;
                }

                this.$root.$emit("filter-creatives-button-clicked", filter);
            }
        },
        created() {
            this.fillAllModels();
        }
    }

</script>

<style scoped>

    hr {
        padding-top: 0;
        margin: 0 0 20px 0;
        color: #DBDBD8;
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
    }

    .navigation {
        border-radius: 5px;
        background-color: white;
        margin-bottom: 30px;
    }

    select {
        border: none;
        background-color: #EEF3F8;
        color: black;
        display: block;
        width: calc(100% - 40px);
        padding: 12px 15px 12px 15px;
        border-radius: 5px;
        font-size: 15px;
        margin: 0 20px 20px 20px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    input[type="text"], input[type="number"] {
        border: none;
        display: block;
        margin: 0 20px 20px 20px;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 15px;
        padding: 12px 15px 12px 15px;
        font-family: 'Open Sans', sans-serif;
        width: calc(100% - 40px);
    }

    .price-wrapper {
        display: inline-block;
        width: calc(50% - 22px);
    }

    input[type="number"] {
        width: 100%;
    }

    .fa-filter {
        font-size: 15px;
        margin-right: 10px;
        transform: translateY(-1px);
    }

    .navigation-title {
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
        font-size: 20px;
        padding: 15px 20px 7px 20px;
    }

    .navigation-button {
        position: relative;
        width: calc(100% - 40px);
        margin: 0 20px 20px 20px;
        font-size: 16px;
        background-color: #2D71BC;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 10px 8px 10px;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
    }

    .navigation-button:hover {
        outline: none;
        background-color: #193777;
    }

    @media(max-width:767px) {

        .navigation-wrapper {
            height: auto;
        }

    }

</style>