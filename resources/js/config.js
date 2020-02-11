/*
    Defines the API route we are using.
*/
let api_url = '';


switch (process.env.NODE_ENV) {
    case 'development':
        api_url = 'http://locahost:8001/api';
        break;
    case 'production':
        api_url = 'https://topproducts.es/api';
        break;
}


export const REFERRALS_CONFIG = {
    API_URL: api_url,
};
