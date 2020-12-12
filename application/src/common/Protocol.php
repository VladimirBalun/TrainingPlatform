<?php

/*
 * Copyright 2018 Vladimir Balun
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace App\Common {

    /*
     * This constants use in protocol between client application, because
     * if you want ot change this constant, you'll need to change the same
     * constant value in the client application
     */

    class Protocol {

        // Signup
        public static $SIGNUP_SUCCESS = 0;
        public static $SIGNUP_ERROR_USERNAME_EXISTS = 1;
        public static $SIGNUP_ERROR_EMAIL_EXISTS = 2;
        public static $SIGNUP_ERROR_INCORRECT_USERNAME = 3;
        public static $SIGNUP_ERROR_INCORRECT_EMAIL = 4;
        public static $SIGNUP_ERROR_INCORRECT_PASSWORD = 5;
        public static $SIGNUP_ERROR_UNKNOWN = 6;

        // Login
        public static $LOGIN_SUCCESS = 0;
        public static $LOGIN_ERROR_INCORRECT_EMAIL = 1;
        public static $LOGIN_ERROR_INCORRECT_PASSWORD = 2;
        public static $LOGIN_ERROR_INCORRECT_EMAIL_OR_PASSWORD = 3;
        public static $LOGIN_ERROR_UNKNOWN = 4;

        // Moderation
        public static $MODERATION_STATUS_IN_PROGRESS = 0;
        public static $MODERATION_STATUS_SUCCESS = 1;
        public static $MODERATION_STATUS_FAILED = 2;

        // Filters
        public static $FILTER_ONLINE_OR_OFFLINE_NONE = 0;
        public static $FILTER_OFFLINE = 1;
        public static $FILTER_ONLINE = 2;

        public static $SORTING_NONE = 0;
        public static $SORTING_BY_DATE_ASC = 1;
        public static $SORTING_BY_DATE_DESC = 2;
        public static $SORTING_BY_PRICE_ASC = 3;
        public static $SORTING_BY_PRICE_DESC = 4;
        public static $SORTING_BY_NAME_ASC = 5;
        public static $SORTING_BY_NAME_DESC = 6;
    }

}


