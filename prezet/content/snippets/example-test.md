---
title: Javascript Array Map Example
excerpt: A simple demonstration of how to use the map function in Javascript.
date: 2026-03-07
category: snippets
language: javascript
image: /prezet/img/ogimages/snippets-example-test.webp
---

```javascript
const numbers = [1, 4, 9];
const roots = numbers.map((num) => Math.sqrt(num));

// roots is now [1, 2, 3]
// numbers is still [1, 4, 9]
console.log(roots);
```
