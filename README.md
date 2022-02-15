# Aloware Test Project

Create a comment system single-page web application using a framework of choice (preferably Laravel 5.5+) and VueJS / React.

## Stack

-   Laravel 9
-   Vue 2

## Installation

Clone the repository

```bash
git clone git@github.com:AnsellC/aloware.git
```

Laravel installation is using Laravel Sail. Make sure to have Docker installed and running.

```bash
cd api && ./vendor/bin/sail up
```

Install Vue dependencies

```bash
cd app && npm i
```

Open `app/config.json` and edit the `api_endpoint` value to point to the Laravel installation.

Run frontend

```bash
npm run serve
```

Visit: `http://localhost:8080` and test. (port can change depending if the port is already taken)

---

## Backend Notes

-   Since the app specifically mentions not to create a `Post` model, the dummy post on the app is hard coded.
-   The `Comment` model does not have a field for `post_id`. This is intentionally left out due to the specifications mentioned above.
-   `Comment` model contains a `depth` field to limit depth. Otherwise, this can be
-   Caching isn't added on the API response but can be easily added by caching the comments on first load (with expiry) and then busting the cache when a post is created.
-   No authentication is added.

## Frontend Notes

-   Typescript is used.
-   TailwindCSS CDN version is used to quickly prototype and design the UI for development purposes only. I would use the traditional method in production.
-   All the comments are reloaded every time a comment is made. Another method can be used which is pushing the newly created comment into the comment array. But for demonstration purposes, I used the first one.
