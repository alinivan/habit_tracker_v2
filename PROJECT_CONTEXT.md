# Context Proiect Habit Tracker

## Structură Proiect
Proiectul este o aplicație Symfony pentru urmărirea obiceiurilor (habits), cu următoarele componente principale:

### Entități
1. **User**
   - Autentificare bazată pe email
   - Relații One-To-Many cu Category și Habit
   - Roluri pentru autorizare

2. **Category**
   - Organizează habits pe categorii
   - Aparține unui user
   - Conține: nume, ordine, relație cu habits

3. **Habit**
   - Entitatea principală pentru tracking
   - Proprietăți:
     - name: numele obiceiului
     - minValue: valoarea minimă necesară
     - order: ordinea de afișare
     - points: puncte acordate
     - active: status activ/inactiv
     - measurement: unitatea de măsură (min/kg)
     - isProductive: flag pentru productivitate
     - valueType: tip valoare (number/boolean)
     - Relații cu User, Category și Habit părinte

4. **Tracker**
   - Înregistrează valorile pentru habits
   - Stochează: valoare, puncte, data, createdAt
   - Relații cu User și Habit

### Controllers
1. **SecurityController**
   - Gestionează autentificarea
   - Login/Logout

2. **DashboardController**
   - Pagina principală
   - Afișează statistici:
     - Ore productive
     - Ora de start
     - Media punctelor
     - Ultima greutate înregistrată

3. **HabitController**
   - CRUD pentru habits
   - Vizualizare grafică a progresului
   - Formulare pentru adăugare/editare

4. **TrackerController**
   - API pentru înregistrarea valorilor
   - Vizualizare istoric

5. **CategoryController**
   - CRUD pentru categorii
   - Organizare habits

### Services
1. **ChartService**
   - Generează date pentru grafice
   - Procesează date istorice

2. **DashboardService**
   - Calculează statistici pentru dashboard
   - Agregă date din tracker

3. **TrackerService**
   - Logică pentru înregistrarea valorilor
   - Calculul punctelor
   - Gestionarea perioadelor

### Repositories
1. **TrackerRepository**
   - Queries pentru date statistice
   - Filtrare pe intervale de timp
   - Calcule agregate (sume, medii)

2. **CategoryRepository**
   - Queries pentru categorii cu habits
   - Filtrare pe user

### Forms
1. **HabitType**
   - Form pentru habits
   - Validare
   - Dependență de user pentru categorii

## Funcționalități Cheie
1. **Tracking Habits**
   - Înregistrare zilnică
   - Suport pentru valori numerice și boolean
   - Calculul automat al punctelor

2. **Dashboard**
   - Vizualizare rapidă a progresului
   - Statistici zilnice și săptămânale
   - Organizare pe categorii

3. **Grafice și Statistici**
   - Vizualizare progres în timp
   - Calcul productivitate
   - Sumar puncte

4. **Securitate**
   - Autentificare completă
   - Separare date pe user
   - CSRF protection

## Tehnologii
- Symfony 6.x
- Doctrine ORM
- Twig Templates
- Tailwind CSS
- Chart.js pentru grafice
- MySQL/MariaDB

## Convenții
1. **Routing**
   - Prefix /habits pentru habits
   - Prefix /tracker pentru tracking
   - Root (/) pentru dashboard

2. **Templates**
   - Organizate pe secțiuni (/templates/habit, /templates/dashboard)
   - Folosesc Tailwind pentru styling
   - Moștenesc base.html.twig

3. **Forms**
   - Folosesc form-input și form-select pentru styling
   - Validare server-side
   - CSRF protection 