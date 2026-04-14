---
title: "Laravel Databases: Eloquent & Beyond"
description: "Master the data layer: Eloquent ORM, Relationships, Query Builder, Migrations, and Performance."
date: "2026-04-14"
tags: ["laravel", "database", "eloquent", "orm", "performance"]
---

# 📌 Topic: Databases

Data is the lifeblood of any application. Laravel's Eloquent ORM is legendary, but understanding the mechanics behind it is what separates good developers from great ones.

## 🟢 Beginner Level (Core Operations)

<details>
  <summary>Q1: What is an ORM (specifically Eloquent) and why use it?</summary>
  
  **Answer:** 
  **Object-Relational Mapper (ORM)** is a technique that lets you query and manipulate data from a database using an object-oriented paradigm. 
  
  **Why:** Instead of writing raw SQL strings (`SELECT * FROM users`), you work with PHP objects (`User::all()`). This makes code more readable, maintainable, and prevents many common security issues like SQL injection.
</details>

<details>
  <summary>Q2: What is the purpose of Migrations?</summary>
  
  **Answer:** 
  Migrations are **Version Control for your database**. 
  
  **Analogy:** Just as Git tracks changes in your code, Migrations track changes in your database schema. This allows a team of developers to keep their local databases in sync by simply running a command.
</details>

<details>
  <summary>Q3: Explain the difference between `hasOne` and `belongsTo`.</summary>
  
  **Answer:** 
  It’s about where the **Foreign Key** is stored.
  - If Class A **has** the foreign key of Class B, then A `belongsTo` B.
  - If Class B **has** the foreign key of Class A, then A `hasOne` B.
</details>

---

## 🟡 Intermediate Level (Optimization & Internals)

<details>
  <summary>Q1: What is "N+1 Query Problem" and how do you fix it?</summary>
  
  **Answer:** 
  The N+1 problem occurs when you fetch a list of records (1 query) and then loop through them to fetch a related record for each (N queries). 
  
  **Fix:** Use **Eager Loading** via the `with()` method. 
  `User::with('posts')->get()` runs only 2 queries total, regardless of how many users there are.
</details>

<details>
  <summary>Q2: When should you use the "Query Builder" instead of "Eloquent"?</summary>
  
  **Answer:** 
  Eloquent provides convenience but adds overhead (instantiating models, processing dates, etc.). 
  
  **Use Query Builder when:**
  1. Performing bulk updates/deletes.
  2. Generating complex reports with many joins where you don't need the actual Model objects.
  3. Performance is absolutely critical for a very high-traffic read operation.
</details>

<details>
  <summary>Q3: What are "Query Scopes" and why are they important?</summary>
  
  **Answer:** 
  Scopes allow you to define common sets of constraints that you may easily re-use throughout your application. 
  
  **Why:** Instead of repeating `->where('active', true)->where('votes', '>', 100)` everywhere, you define a `scopePopular()` method. This makes your code **Declarative** and easy to read: `User::popular()->get()`.
</details>

---

## 🔴 Advanced Level (Deep Mechanics)

<details>
  <summary>Q1: How does Eloquent's "Lazy Loading" work under the hood?</summary>
  
  **Answer:** 
  Eloquent uses PHP **Magic Properties**. When you access `$user->posts`, Laravel checks if the `posts` relationship is already loaded. If not, it looks for a `posts()` method on the model, executes the query, and caches the result in the model's internal `$relations` array.
</details>

<details>
  <summary>Q2: Describe the "Active Record" pattern vs. the "Data Mapper" pattern.</summary>
  
  **Answer:** 
  - **Active Record (Eloquent):** The model *is* the data and the logic. `$user->save()` handles the DB interaction. It's simple and fast to develop.
  - **Data Mapper (Doctrine/Symfony):** The model is a pure "POPO" (Plain Old PHP Object). A separate "EntityManager" handles the DB. It's more decoupled but more complex.
  
  **Senior View:** Active Record is perfect for rapid development and medium complexity. For extreme decoupling in massive enterprise apps, some architects layer a Repository on top of Eloquent to mimic Data Mapper benefits.
</details>

<details>
  <summary>Q3: Explain "Polymorphic Relationships".</summary>
  
  **Answer:** 
  A polymorphic relationship allows a target model to belong to more than one type of model using a single association. 
  
  **Example:** An `Image` model could belong to both a `User` and a `Product`. Instead of two foreign keys, you use `imageable_id` and `imageable_type` (which stores the class name).
</details>

---

## 🧠 Architect Level (Scalability)

<details>
  <summary>Q1: How would you handle a database table with 100 million rows in Laravel?</summary>
  
  **Answer:** 
  1. **Indexing:** Ensure critical columns are indexed.
  2. **Chunking:** Use `chunk()` or `cursor()` for processing records to avoid memory exhaustion.
  3. **Partitioning:** Partition the table at the DB level (e.g., by date).
  4. **Read/Write Splitting:** Configure Laravel to use a "Read" replica database for SELECTs and a "Write" master for others.
  5. **Caching:** Aggressively cache frequently accessed data or use a search engine like Elasticsearch for complex filtering.
</details>

<details>
  <summary>Q2: When would you use "Soft Deletes" and what are the trade-offs?</summary>
  
  **Answer:** 
  **Use for:** Auditing, user error recovery, or preserving data integrity for linked records.
  
  **Trade-offs:** 
  - Unique indexes become tricky (a soft-deleted 'email' will block a new user with that same email). 
  - Queries become slightly slower as every query now includes `WHERE deleted_at IS NULL`.
  - Database size grows indefinitely unless you have a cleanup/archiving strategy.
</details>

---

## 🚀 Interview Tips

* **What interviewer REALLY wants to hear:** That you understand **Query Efficiency**. Mentioning "Eager Loading" and "Indexing" is a must.
* **Common Trap:** Thinking Eloquent is the only way to talk to the DB. Always acknowledge that raw SQL or Query Builder is better for certain high-performance scenarios.
* **Senior-level Answer:** When talking about relationships, mention **Database Constraints**. Explain that Eloquent relationships are code-level, but you should *also* have Foreign Key constraints at the DB level for data integrity.
* **Key Phrases:** "Eager Loading," "Lazy Loading," "Magic Methods," "Casting," "Global Scopes," "Mass Assignment," "Race Conditions."
