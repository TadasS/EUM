EPIC, user management system
============================

System is running on symfony 2.8 version.
Mostly because as far as i know it's used by NFQ.

Instalation:
1. Clone / download source code
2. Update composer
3. Configure app/config/parameters.yml
4. Install data fixtures
5. Login using "admin" username && password.

What's inside:
1. Users && groups entities (many to many relationship) with CRUD.
2. API with wsse authentication (call me to find out more ;D)
3. Data fixtures.
4. Some console commands.
5. Translations.

I choose to write my own API instead of using "FOSRestBundle".