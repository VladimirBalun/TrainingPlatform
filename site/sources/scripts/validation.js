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

export const validateLoginForm = (loginForm) => {
    loginForm.validation.email = true;
    loginForm.validation.password = true;

    let errorMessage = checkSignupFormOnEmpty(loginForm);
    if (errorMessage !== "") {
        return errorMessage;
    }

    errorMessage = checkSignUpFormOnValidInformation(loginForm);
    if (errorMessage !== ""){
        return errorMessage;
    }

    return "";
};

function checkLoginFormOnEmpty(loginForm) {
    if (loginForm.model.email === "") {
        loginForm.validation.email = false;
        return "E-mail не может быть пустым"
    }
    if (loginForm.model.password === "") {
        loginForm.validation.password = false;
        return "Пароль не может быть пустым";
    }

    return "";
}

function checkLoginFormOnValidInformation(loginForm) {
    if (!validateEmail(loginForm.model.email)) {
        loginForm.validation.email = false;
        return "Некорректный e-mail адрес";
    }

    return "";
}

export const validateSignupForm = (signupForm) => {
    signupForm.validation.username = true;
    signupForm.validation.email = true;
    signupForm.validation.password = true;
    signupForm.validation.privacyPolicy = true;

    let errorMessage = checkSignupFormOnEmpty(signupForm);
    if (errorMessage !== "") {
        return errorMessage;
    }

    errorMessage = checkSignUpFormOnValidInformation(signupForm);
    if (errorMessage !== ""){
        return errorMessage;
    }

    return "";
};

function checkSignupFormOnEmpty(signupForm) {
    if (signupForm.model.username === "") {
        signupForm.validation.username = false;
        return "Имя пользователя не может быть пустым"
    }
    if (signupForm.model.email === "") {
        signupForm.validation.email = false;
        return "E-mail не может быть пустым"
    }
    if (signupForm.model.password === "") {
        signupForm.validation.password = false;
        return "Пароль не может быть пустым";
    }
    if (signupForm.model.privacyPolicy === false) {
        signupForm.validation.privacyPolicy = false;
        return "Необходимо принять политику конфиденциальности";
    }

    return "";
}

function checkSignUpFormOnValidInformation(signupForm) {
    if (!validateUsername(signupForm.model.username)) {
        signupForm.validation.username = false;
        return "Некорректное имя пользователя";
    }
    if (!validateEmail(signupForm.model.email)) {
        signupForm.validation.email = false;
        return "Некорректный e-mail адрес";
    }

    return "";
}

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
        if (!validateEmail(creativeForm.creative.email)) {
            creativeForm.creativeValidation.email = false;
            return "Некорректный e-mail адрес";
        }
    }
    if (creativeForm.creative.image !== "") {
        if (!validateLinkAddress(creativeForm.creative.image)) {
            creativeForm.creativeValidation.image = false;
            return "Некорректный адрес изображения";
        }
    }
    if (creativeForm.creative.site !== "") {
        if (!validateLinkAddress(creativeForm.creative.site)) {
            creativeForm.creativeValidation.site = false;
            return "Некорректный адрес сайта";
        }
    }

    return "";
}

export const validateUsername = (username) => {
    const regex = /^[a-zA-Z0-9]+$/;
    return regex.test(username);
};

export const validateEmail = (email) => {
    const regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    return regex.test(email);
};

export const validateLinkAddress = (address) => {
    const regex = /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;
    return regex.test(address);
};
