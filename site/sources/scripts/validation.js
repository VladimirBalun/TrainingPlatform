/*
 * Copyright 2018 Vladimir Balun
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

"use strict";

export const validateCreativeEventDate = (eventDate) => {
    const current = new Date();
    const event = new Date(eventDate);
    current.setHours(0,0, 0, 0);
    event.setHours(0,0, 0, 0);
    return (current <= event) || (eventDate === null);
};

export const validateCreativeForm = (creativeForm) => {
    creativeForm.creativeValidation.city = true;
    creativeForm.creativeValidation.briefDescription = true;
    creativeForm.creativeValidation.description = true;
    creativeForm.creativeValidation.category = true;
    creativeForm.creativeValidation.eventDate = true;
    creativeForm.creativeValidation.theme = true;
    creativeForm.creativeValidation.price = true;
    creativeForm.creativeValidation.image = true;
    creativeForm.creativeValidation.email = true;
    creativeForm.creativeValidation.site = true;

    let errorMessage = checkCreativeFormOnEmpty(creativeForm);
    if (errorMessage !== ""){
        return errorMessage;
    }

    errorMessage = checkCreativeFormOnValidInformation(creativeForm);
    if (errorMessage !== ""){
        return errorMessage;
    }

    return "";
};

function checkCreativeFormOnEmpty(creativeForm) {
    if (creativeForm.creative.title === "") {
        creativeForm.creativeValidation.title = false;
        return "Название объявления не может быть пустым";
    }
    if (creativeForm.creative.briefDescription === "") {
        creativeForm.creativeValidation.briefDescription = false;
        return "Краткое описание объявления не может быть пустым";
    }
    if (creativeForm.creative.description === "") {
        creativeForm.creativeValidation.description = false;
        return "Описание объявления не может быть пустым";
    }
    if (creativeForm.creative.category === "Не выбрано") {
        creativeForm.creativeValidation.category = false;
        return "Необходимо выбрать категорию";
    }
    if (creativeForm.creative.theme === "Не выбрано") {
        creativeForm.creativeValidation.theme = false;
        return "Необходимо выбрать тему";
    }
    if (creativeForm.creative.price === "") {
        creativeForm.creativeValidation.price = false;
        return "Необходимо ввести цену, если услуга бесплатная - нужно указать ноль";
    }

    return "";
}

function checkCreativeFormOnValidInformation(creativeForm) {
    if (creativeForm.creative.eventDate !== "") {
        if (!validateCreativeEventDate(creativeForm.creative.eventDate)) {
            creativeForm.creativeValidation.eventDate = false;
            return "Невозможно указать дату события в прошлом";
        }
    }
    if (creativeForm.creative.email !== "") {
        const regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        if (!regex.test(creativeForm.creative.email)) {
            creativeForm.creativeValidation.email = false;
            return "Некорректный e-mail адрес";
        }
    }
    if (creativeForm.creative.image !== "") {
        const regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
        if (!regex.test(creativeForm.creative.image)) {
            creativeForm.creativeValidation.image = false;
            return "Некорректный адрес изображения";
        }
    }
    if (creativeForm.creative.site !== "") {
        const regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
        if (!regex.test(creativeForm.creative.site)) {
            creativeForm.creativeValidation.site = false;
            return "Некорректный адрес сайта";
        }
    }

    return "";
}
