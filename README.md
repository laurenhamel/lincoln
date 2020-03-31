# Lincoln

> A link in bio launchpad powered by Airtable

## Installation

- Clone the repository.

```bash
git clone git@github.com:laurenhamel/lincoln.git
```

- Install dependencies.

```bash
npm install && composer install
```

- Create an [AirTable](https://airtable.com/) base to store your links. If using the default configurations, then make sure your AirTable contains columns named `Title` and `Link` for the link name and URL, respectively.

- Setup your `.env` file. See [`.env.example`](https://github.com/laurenhamel/lincoln/blob/master/.env.example) for help.

- Build the project.

```bash
# For development environments:
grunt build:dev

# For production environments:
grunt build:prod
```

- Start adding links into your AirTable base, include a link to your project in all your socials, and enjoy!
