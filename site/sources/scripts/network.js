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

const restAddress = "http://localhost:8080";
const scriptAddress = "http://mysite.local/trening/application/src/";

function getServerAddress() {
    if (process.env.PRODUCTION_MODE) {
        return "";
    } else if (process.env.DEVELOPMENT_MODE) {
        return "http://mysite.local/trening/application/src/";
    } else {
        throw "Unknown environment mode. You need to use PRODUCTION_MODE or DEVELOPMENT_MODE";
    }
}

export const loadMetaInformation = (vueResource, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.get(restAddress + "/meta")
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const loadCitiesByCountryName = (vueResource, countryName, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.get(restAddress + "/cities", { params: { country_name: countryName } })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const removeCreativeById = (vueResource, creativeId, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.put(scriptAddress + "api/creatives/delete_creative_by_id.php", {creative_id: parseInt(creativeId)}, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};

export const addCreativeByAdvertiserId = (vueResource, advertiserId, creative, onSuccessLoadClb, onFailedLoadClb) => {
    correctCreativeForResponse(creative);
    creative.advertiser_id = advertiserId;
    vueResource.$http.post(scriptAddress + "api/creatives/add_creative.php", creative, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
}

export const changeCreative = (vueResource, creative, onSuccessLoadClb, onFailedLoadClb) => {
    vueResource.$http.put(scriptAddress + "api/creatives/change_creative.php", creative, { emulateJSON: true })
        .then(response => {
            console.log(response);
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
}

function correctCreativeForResponse(creative) {
    if (creative.country === "Не выбрано") {
        creative.country = null
    }
    if (creative.city === "Не выбрано") {
        creative.city = null;
    }
    if (creative.eventDate === "") {
        creative.eventDate = null;
    }
    if (creative.email === "") {
        creative.email = null;
    }
    if (creative.number === "") {
        creative.number = null;
    }
    if (creative.site === "") {
        creative.site = null;
    }
}

export const changeAdvertiserImageUrlById = (vueResource, advertiserId, newAdvertiserImageUrl, onSuccessLoadClb, onFailedLoadClb) => {
    const request = {};
    request.advertiser_id = advertiserId;
    request.new_image_url = newAdvertiserImageUrl;
    vueResource.$http.put(scriptAddress + "api/advertisers/change_advertiser_image_by_id.php", request, { emulateJSON: true })
        .then(response => {
            onSuccessLoadClb(response.body);
        }, error => {
            onFailedLoadClb(error);
        });
};