# Smart-Laundry-Management-System-with-AI

A modern web-based Laundry Management System built with **PHP**, **MySQL**, **HTML/CSS/JS**, and integrated **DeepSeek R1 AI API** to help businesses streamline operations and make smarter decisions.

---
![image](https://github.com/user-attachments/assets/31cf5cd7-ef5a-47e1-a85f-eebe7d0b98fb)
![image](https://github.com/user-attachments/assets/0edc2184-f4d4-451d-934f-9bb39542cd20)

## 🚀 Features

- 🔐 **Authentication**
  - User registration & login system

- 🧠 **AI Chatbot (DeepSeek R1)**
  - Real-time AI assistant for users
  - Revenue prediction based on invoice data
  - Natural language support for analytics

- 🧾 **Invoice Management**
  - Create, view, edit, and delete invoices
  - Track services and billing per customer

- 🧼 **Service Management**
  - Manage laundry services (e.g. washing, drying, ironing)
  - Set dynamic pricing

- 👥 **Customer Management**
  - Add, update, and manage customer profiles

- 📈 **Dashboard & Charts** (Coming soon)
  - Visualize revenue, usage statistics, and service trends

---

## 🧰 Tech Stack

| Layer       | Technology        |
|-------------|-------------------|
| Backend     | PHP, MySQL        |
| Frontend    | HTML, CSS, JavaScript, Bootstrap |
| AI Assistant| DeepSeek R1 via OpenRouter API |
| Charts      | Chart.js (optional) |

---

## 💡 AI Integration: DeepSeek R1

The system connects to **DeepSeek R1 API** via OpenRouter to:

- Answer user queries related to customer, invoice, or services
- Predict revenue for the current or upcoming months
- Support future expansion into smart recommendations

---

## 📂 Project Structure (simplified)

```
/config         - DB connection setup  
/controllers    - PHP logic for handling each feature  
/views          - Frontend pages (HTML + PHP mix)  
/api/AIController.php - Handles AI API requests  
/assets         - CSS, JS, icons  
```

---

## 🛠 Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/chianhluvC/Smart-Laundry-Management-System-with-AI.git
   ```

2. **Import Database**
   - Open `phpMyAdmin`
   - Import the SQL dump (e.g., `laundry_db.sql`)

3. **Configure Database**
   - Edit `/config/database.php` with your MySQL credentials

4. **Set Up OpenRouter API**
   - In `AIController.php`, set your API Key from OpenRouter to use DeepSeek R1

5. **Run on Localhost**
   - Use XAMPP or any local server, place project folder in `/htdocs`

---

## 🤖 Sample AI Query

> "Predict the expected revenue for next month based on current invoices."

> "Show me all invoices for customer Tom."

---

## 📜 License

MIT License – feel free to use and modify for learning or business purposes.

---

