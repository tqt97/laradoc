---
title: Security Deep Dive
excerpt: "Hướng dẫn bảo mật Laravel ở cấp độ Staff/Architect: phân tích attack vector thực tế (CSRF, XSS, SQLi, SSRF, RCE), authentication/authorization nâng cao, token security, encryption, secure upload, và chiến lược defense-in-depth trong production."
category: Laravel
date: 2026-03-08
order: 16
image: /prezet/img/ogimages/series-laravel-advanced-security.webp
---

Ở level Staff, bạn không chỉ “bảo vệ hệ thống” — bạn phải **nghĩ như attacker**:

* Họ có thể inject gì?
* Họ có thể bypass ở đâu?
* Họ có thể abuse logic business không?

Security = attacker mindset + system design

## I. Security Principles (Core)

### 1. Defense in Depth

Không tin vào 1 layer duy nhất:

* Validate input
* Escape output
* Auth + Policy
* Infra (WAF, CDN)

### 2. Least Privilege

User/service chỉ có quyền tối thiểu cần thiết.

### 3. Fail Securely

* Khi lỗi → deny, không allow

## II. Authentication Deep Dive

### 1. Session Fixation

**Attack**

* Attacker set session trước
* User login → reuse session

**Fix**

```php
Auth::login($user);
$request->session()->regenerate();
```

### 2. Token Hijacking

**Attack**

* Token bị leak (XSS, network)

**Fix**

* HTTPS only
* HttpOnly cookie
* Short TTL

### 3. Refresh Token Rotation

**Flow**

1. Access token hết hạn
2. Dùng refresh token
3. Generate token mới + revoke token cũ

Tránh reuse token bị đánh cắp

## III. Authorization (Real-world)

### RBAC vs ABAC

| Type | Mô tả           |
| ---- | --------------- |
| RBAC | Role-based      |
| ABAC | Attribute-based |

### Policy bypass bug

```php
if ($user->isAdmin()) {
    return true;
}
```

Nếu admin bị hack → toàn hệ thống bị bypass

### Multi-tenant security

```php
Post::where('tenant_id', auth()->user()->tenant_id)
```

Không filter → data leak 💥

## IV. XSS (Advanced)

**Stored vs Reflected**

* Stored: lưu DB
* Reflected: qua URL

**Bypass**

```html
<img src=x onerror=alert(1)>
```

**Laravel Fix**

```php
{{ $data }} // escape
```

**Advanced**

* Content Security Policy (CSP)

## V. SQL Injection (Advanced)

**ORM không phải luôn safe**

```php
User::whereRaw("email = '$email'")
```

vẫn dính injection

**Fix**

```php
User::where('email', $email)
```

## VI. SSRF (Server-Side Request Forgery)

**Attack**

```php
file_get_contents($url);
```

Attacker gửi:

```
http://localhost:3306
```

access internal service

**Fix**

* Validate URL
* Block internal IP

## VII. File Upload RCE

**Attack**

Upload file `.php`

```php
<?php system($_GET['cmd']); ?>
```

**Fix**

```php
$request->validate([
    'file' => 'mimes:jpg,png'
]);
```

* Rename file
* Store outside public

## VIII. Encryption - Key Management

**Problem**

* Key leak = toàn bộ data leak

**Strategy**

* Rotate key
* Use env + secret manager

## IX. Replay Attack (Deep)

**Attack**

* Gửi lại request cũ

**Fix**

* Nonce
* Timestamp
* Idempotency key

## X. Brute Force Defense

```php
Route::middleware('throttle:5,1');
```

Advanced:

* CAPTCHA
* IP ban

## XI. Secure Headers

```php
X-Frame-Options: DENY
Content-Security-Policy: default-src 'self'
```

## XII. Secrets Management

**Problem**

* Leak .env

**Fix**

* Không commit .env
* Dùng Vault / AWS Secrets Manager

## XIII. Logging & Monitoring

* Log auth
* Detect anomaly
* Alert

## XIV. Attack Surface Mapping

**Entry points**

* API
* Upload
* Auth

Phải audit toàn bộ

## XV. Interview Questions (Staff Level – Real Interview Simulation)

> Phần này được thiết kế theo format phỏng vấn thật: có câu hỏi tình huống, follow-up deep dive, và đánh giá tư duy hệ thống (không phải định nghĩa học thuộc).

**CSRF trong hệ thống thực tế**

<details open>
<summary>Q1: CSRF là gì và trong Laravel cơ chế chống CSRF hoạt động như thế nào?</summary>

**Trả lời chuẩn:**
CSRF (Cross-Site Request Forgery) là tấn công khi attacker khiến user đã đăng nhập thực hiện hành động không mong muốn.

**Cơ chế Laravel:**

* Laravel sinh CSRF token cho mỗi session
* Token được gửi qua form / header
* Middleware VerifyCsrfToken kiểm tra token

**Follow-up deep:**

* CSRF có xảy ra với API stateless không?
  → Không, nếu dùng JWT đúng cách (không dùng cookie)

* Nếu disable CSRF thì nguy hiểm gì?
  → Bất kỳ form POST nào cũng có thể bị forge

</details>

**XSS và impact production**

<details>
<summary>Q2: Phân biệt Stored XSS và Reflected XSS? Trong hệ thống lớn impact là gì?</summary>

**Trả lời:**

* Stored XSS: payload lưu DB → ảnh hưởng toàn user
* Reflected XSS: qua URL → ảnh hưởng từng request

**Impact production:**

* Steal session cookie
* Inject script vào dashboard admin
* Chain attack → account takeover

**Follow-up:**

* Vì sao {!! !!} trong Blade nguy hiểm?
* CSP có thay thế được escape không?
  → Không, CSP chỉ là layer bổ sung

</details>

**SQL Injection (Real-world thinking)**

<details>
<summary>Q3: ORM của Laravel có hoàn toàn chống SQL Injection không?</summary>

**Trả lời:**
Không hoàn toàn.

**Nguy hiểm nằm ở:**

```php
DB::select("SELECT * FROM users WHERE email = '$email'");
```

**Follow-up:**

* Eloquent whereRaw có an toàn không?
→ Không nếu inject string trực tiếp

* Làm sao DB layer chống injection?
→ Prepared statements

</details>

**Authentication (production mindset)**

<details>
<summary>Q4: Session fixation attack là gì và Laravel chống nó thế nào?</summary>

**Trả lời:**
Attacker ép user dùng session ID có sẵn, sau login session bị chiếm.

**Laravel fix:**

```php
$request->session()->regenerate();
```

**Follow-up:**

* Vì sao regenerate session quan trọng sau login?
→ tránh reuse session cũ

</details>

**JWT vs OAuth2 (system design)**

<details>
<summary>Q5: Khi nào dùng JWT và khi nào dùng OAuth2?</summary>

**Trả lời:**

* JWT: internal API, microservice, stateless
* OAuth2: third-party authorization, delegated access

**Follow-up deep:**

* JWT có revoke được không?
→ Không dễ (vì stateless)

* Giải pháp revoke JWT?
→ blacklist hoặc short TTL + refresh token

</details>

**SSRF (Staff level question)**

<details>
<summary>Q6: SSRF là gì? Vì sao rất nguy hiểm trong hệ thống cloud?</summary>

**Trả lời:**
Server bị ép gửi request đến internal system.

**Ví dụ:**

* [http://localhost:3306](http://localhost:3306)
* [http://169.254.169.254](http://169.254.169.254) (AWS metadata)

**Impact:**

* Lộ AWS credentials
* Access internal service

**Follow-up:**

* Chặn SSRF như thế nào?
→ whitelist domain + block private IP range

</details>

**File Upload RCE**

<details>
<summary>Q7: File upload có thể dẫn đến RCE như thế nào?</summary>

**Trả lời:**
Upload file chứa PHP code → server execute

**Fix:**

* Validate mime type
* Store outside public
* Rename file random

**Follow-up:**

* mime validation có đủ không?
→ Không (có thể fake)

</details>

**Multi-tenant security**

<details>
<summary>Q8: Làm sao tránh data leak trong multi-tenant system?</summary>

**Trả lời:**
Luôn enforce tenant scope ở query layer

```php
Post::where('tenant_id', auth()->user()->tenant_id)
```

**Follow-up:**

* Nếu dev quên filter thì sao?
→ dùng global scope

</details>

**Replay attack**

<details>
<summary>Q9: Replay attack là gì và giải pháp production?</summary>

**Trả lời:**
Gửi lại request cũ để duplicate action

**Fix:**

* nonce
* timestamp
* idempotency key

**Follow-up:**

* khác gì idempotency?
→ replay = attack, idempotency = design

</details>

**System thinking question**

<details>
<summary>Q10: Nếu hệ thống API bị traffic 10x đột ngột + có attack bot, bạn xử lý thế nào?</summary>

**Trả lời kỳ vọng (Staff level):**

* Rate limiting (Redis)
* CDN / WAF
* Cache layer
* Queue offload
* Block IP anomaly

**Follow-up:**

* Bottleneck đầu tiên thường là gì?
→ DB + connection pool

</details>

## XVI. Tổng kết Tổng kết

Ở level Staff:

* Phải hiểu attacker nghĩ gì
* Phải audit toàn hệ thống
* Phải build nhiều layer defense

Security không phải feature → là nền tảng
