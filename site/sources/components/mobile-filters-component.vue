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
        <div class="modal fade" id="mobile-filters-modal" tabindex="-1" ref="closeButton" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Фильтры</h5>
                        <button type="button" class="modal-close-button" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-window-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="modal-button" data-dismiss="modal">Отмена</button>
                        <button type="button" class="modal-button" @click="onFilterButtonClick">Применить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    "use strict";

    import * as network from "../scripts/network";
    import * as protocol from "../scripts/protocol";

    export default {
        name: "mobile-filters-component",
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
                    self.countriesModel = response.countries;
                    self.themesModel = response.themes;
                    self.categoriesModel = response.categories;
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
                this.$refs.closeButton.click();

            }
        },
        created() {
            this.fillAllModels();
        }
    }

</script>

<style scoped>

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

    .modal-title {
        float: left;
        font-size: 21px;
        padding-top: 2px;
        font-family: 'Roboto', sans-serif;
    }

    .modal-body-text {
        color: #666666;;
        font-size: 16px;
        font-family: 'Open Sans', sans-serif;
        margin-bottom: 5px;
    }

    .modal-close-button {
        border: none;
        padding: 0;
        outline: none;
        background-color: transparent;
        color: #10367B;
        font-size: 25px;
        float: right;
    }

    .modal-footer {
        padding-top: 15px;
        padding-bottom: 15px;
        background-color: #10367B;
    }

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

    select {
        border: none;
        background-color: #EEF3F8;
        color: black;
        display: block;
        width: 100%;
        padding: 12px 15px 12px 15px;
        border-radius: 5px;
        font-size: 15px;
        margin: 0 0 20px 0;
        font-family: 'Open Sans', sans-serif;
        transition: .3s;
      -webkit-appearance:none;
    }

    input[type="text"], input[type="number"] {
        border: none;
        display: block;
        margin: 0 0 20px 0;
        border-radius: 5px;
        background-color: #EEF3F8;
        font-size: 15px;
        padding: 12px 15px 12px 15px;
        font-family: 'Open Sans', sans-serif;
        width: calc(100% - 40px);
    }

    .price-wrapper {
        display: inline-block;
        width: calc(50% - 2px);
    }

    input[type="number"] {
        width: 100%;
    }

</style>