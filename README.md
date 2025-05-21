# Road Repair Priority Decision Support System (SPK)

This is a web-based Decision Support System (DSS) developed to assist in determining the priority of road repairs using the **Analytical Hierarchy Process (AHP)** and **Simple Additive Weighting (SAW)** methods. It allows users to input alternatives (roads), criteria, and make pairwise comparisons to calculate priority scores.

## 📌 Features

- Manage repair sessions (e.g., monthly or yearly evaluation)
- Add and edit roads (alternatives) per session
- Add evaluation criteria and their types (Benefit/Cost)
- Pairwise comparison input using AHP
- Automatic AHP weight calculation with matrix normalization
- Grade roads based on criteria
- SAW method to compute and rank priority scores
- Results table with ranking for decision making

## ⚙️ Technologies Used

- **Laravel** (Backend Framework)
- **Blade** (Frontend Templating)
- **MySQL** (Database)
- **Tailwind CSS** (Styling)

## 🧩 System Flow

1. Create a new session (e.g., "Q2 Road Repair Evaluation").
2. Define criteria (e.g., Road Damage, Traffic Volume, Cost).
3. Input pairwise comparisons using AHP method.
4. Add road alternatives.
5. Grade each road for each criterion.
6. Run SAW calculation to generate scores and rank.
7. View and analyze results.

## 🗃️ Database Structure (Simplified)

- `sessions` — stores evaluation sessions
- `criteria` — stores evaluation criteria
- `criteria_pairwise` — stores AHP comparison values
- `criteria_weights` — stores weights after AHP calculation
- `alternatives` — stores road data
- `grade_criteria` — stores criteria scores per road
- `ranking_result` — stores SAW results per session

## 🚀 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/spk-road-priority.git
   cd spk-road-priority

2. Install PHP dependencies using Composer:
composer install

3. Install Node.js dependencies and compile assets:
npm install
npm run dev

4. Configure your environment variables:
   - Copy .env.example to .env
   - Update database connection and other settings in .env

cp .env.example .env
php artisan key:generate

5. Run database migrations:
php artisan migrate

6. Start the development server:
php artisan serve
