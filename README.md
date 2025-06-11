# Hetzner API for Drupal 11

Drupal 11-modul der synkroniserer serverdata fra Hetzner Cloud til nodes.

## Features

- Henter servers fra Hetzner Cloud API
- Gemmer som nodes (`hetzner_server`)
- Felter: status, IP, specs, placering m.fl.
- Cron-integration
- AJAX-opdatering og manuel admin-synkronisering
- Views-baseret oversigt (`/admin/content/hetzner-servers`)
- Composer-installation via GitHub

## Installation

1. Tilføj GitHub-repo til dit projekt:

```bash
composer config repositories.hetzner_api vcs https://github.com/bellcom/hetzner_api
composer require bellcom/hetzner_api:^1.0
```

2. Aktiver modulet:

```bash
drush en hetzner_api
```

3. Gå til `Admin > Konfiguration > Services > Hetzner API`
   - Indtast din Hetzner API-nøgle
   - Klik “Synkroniser nu” eller kør `drush cron`

## Krav

- Drupal 11
- Hetzner Cloud API Token (med read access)

## Udviklet af

Bellcom
