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

/*
 * This constants use in protocol between server application, because
 * if you want ot change this constant, you'll need to change the same
 * constant value in the server application
 */

export const MODERATION_STATUS_IN_PROGRESS = 0;
export const MODERATION_STATUS_SUCCESS = 1;
export const MODERATION_STATUS_FAILED = 2;

export const SIGNUP_SUCCESS = 0;
export const SIGNUP_ERROR_USERNAME_EXISTS = 1;
export const SIGNUP_ERROR_EMAIL_EXISTS = 2;
export const SIGNUP_ERROR_INCORRECT_USERNAME = 3;
export const SIGNUP_ERROR_INCORRECT_EMAIL = 4;
export const SIGNUP_ERROR_INCORRECT_PASSWORD = 5;
export const SIGNUP_ERROR_UNKNOWN = 6;
export const SIGNUP_NEED_LOGIN = 6;

export const LOGIN_SUCCESS = 0;
export const LOGIN_ERROR_INCORRECT_EMAIL = 1;
export const LOGIN_ERROR_INCORRECT_PASSWORD = 2;
export const LOGIN_ERROR_INCORRECT_EMAIL_OR_PASSWORD = 3;
export const LOGIN_ERROR_UNKNOWN = 4;

export const FILTER_ONLINE_OR_OFFLINE_NONE = 0;
export const FILTER_OFFLINE = 1;
export const FILTER_ONLINE = 2;

export const SORTING_NONE = 0;
export const SORTING_BY_DATE_ASC = 1;
export const SORTING_BY_DATE_DESC = 2;
export const SORTING_BY_PRICE_ASC = 3;
export const SORTING_BY_PRICE_DESC = 4;
export const SORTING_BY_NAME_ASC = 5;
export const SORTING_BY_NAME_DESC = 6;
