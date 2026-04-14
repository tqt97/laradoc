---
title: "Review Knowledge with Collapsible Sections"
description: "An example of how to use collapsible sections in Markdown."
date: "2026-04-14"
tags: ["example", "knowledge"]
---

Here are some key concepts you should know. Click each one to reveal the answer.

<details>
  <summary>What is a Service Provider?</summary>

  Service providers are the central place of all Laravel application bootstrapping. Your own application, as well as all of Laravel's core services, are bootstrapped via service providers.

  But, what do we mean by "bootstrapping"? In general, we mean **registering** things, including registering service container bindings, event listeners, middleware, and even routes. Service providers are the central place to configure your application.
</details>

<details>
  <summary>What is the Service Container?</summary>

  The Laravel service container is a powerful tool for managing class dependencies and performing dependency injection.
</details>

<details>
  <summary>Explain Middleware in Laravel.</summary>
  
  Middleware provide a convenient mechanism for inspecting and filtering HTTP requests entering your application. For example, Laravel includes a middleware that verifies the user of your application is authenticated.
</details>
