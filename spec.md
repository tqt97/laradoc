# Quizz feature

## 8. UI/UX Standards for Interview Q&A System (Production-ready)

### 8.1 UX Goals

* Help users **understand quickly – remember longer – stay engaged**
* Optimize for **active recall** instead of passive reading
* Simulate **real interview experience**

---

### 8.2 Layout (Flashcard Centered)

* One question per screen
* Centered content
* Clear progress indicator

Structure:

* Header:

  * Progress (e.g., 3/20)
  * Topic name

* Body:

  * Question (large, readable text)
  * Button: "Show Answer"

* After reveal:

  * Answer
  * CTA:

    * "I knew this"
    * "I forgot"

---

### 8.3 UI Components

#### 1. FlashCard

* Display question
* Flip animation on reveal
* States: question / answer

#### 2. ProgressBar

* Show completion percentage
* Animated progress

#### 3. ActionButtons

* Show Answer
* I knew / I forgot

#### 4. TopicSelector

* Topic list
* Tags + question count

#### 5. DifficultyBadge

* Easy / Medium / Hard

---

### 8.4 Typography & Spacing

* Question:

  * 20–24px
  * Bold

* Answer:

  * 16–18px
  * Line-height: 1.6–1.8

* Padding:

  * 24–32px

* Card:

  * Width: 600–800px
  * Border-radius: 12–16px

---

### 8.5 Micro Interactions

* Flip animation (200–300ms)
* Button hover feedback
* Optional delay before showing answer
* Highlight key concepts

---

## 9. UX Business Logic

### 9.1 Study Mode (Flashcard)

* Show one question at a time
* User reveals answer
* Marks:

  * Known → reduce frequency
  * Unknown → increase frequency

---

### 9.2 Quiz Mode

* Random questions
* Multiple choice
* Timer
* Immediate feedback + explanation

---

### 9.3 Review Mode

* Only incorrect questions
* Reset capability

---

### 9.4 Progress Tracking

* Track:

  * Questions completed
  * Completion %
  * Incorrect count

---

### 9.5 Spaced Repetition (Critical)

* Incorrect → shown more often
* Repeated correct → shown less

---

### 9.6 Difficulty System

* Easy / Medium / Hard

---

### 9.7 Tag System

* PHP
* OOP
* Database
* System Design

---

### 9.8 Answer Structure (Interview-ready)

Each answer includes:

1. Short Answer
2. Detailed Explanation
3. Example
4. Common Mistakes

---

## 10. AI Prompt for Generating UI/UX

```
Design a UI/UX for a web application that helps developers practice interview Q&A.

Requirements:

1. Learning Experience:
- Use flashcards (1 question per screen)
- Do not show the answer immediately
- Include a "Show Answer" button
- After revealing, provide 2 options: "I knew this" and "I forgot"

2. Layout:
- Centered card (600–800px)
- Header with progress (e.g., 3/20)
- Body shows the question
- Answer appears after reveal

3. UI/UX:
- Modern, minimal design
- Clear typography
- Spacious layout
- Card flip animation

4. Features:
- Study mode (flashcard)
- Quiz mode (multiple choice)
- Review mode (incorrect questions)
- Progress tracking
- Difficulty levels
- Tag system
- Spaced repetition

5. Answer content:
- Short answer
- Detailed explanation
- Example
- Common mistakes

6. Goals:
- Improve retention
- Simulate real interview experience
- Keep users engaged longer

Output:
- Clear UI layout
- Component breakdown
- UX flow
```
