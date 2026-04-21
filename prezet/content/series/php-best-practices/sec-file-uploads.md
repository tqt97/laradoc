---
title: File Upload Security – Tránh RCE khi upload file
excerpt: "Hướng dẫn bảo mật upload file trong PHP: validate MIME, giới hạn size, random filename, lưu ngoài web root và tránh RCE."
category: PHP Best Practices
date: 2025-09-28
order: 11
image: /prezet/img/ogimages/series-php-best-practices-sec-file-uploads.webp
---

## Vấn đề cốt lõi

👉 Upload file là một trong những **lỗ hổng nguy hiểm nhất** trong web app

Nếu làm sai → attacker có thể:

* Upload shell PHP
* Execute code trên server
* Chiếm quyền hệ thống

## Bad Example (Anti-pattern)

```php
move_uploaded_file($file['tmp_name'], "uploads/{$file['name']}");
```

### Vấn đề

* Không validate
* Dùng tên file user → dễ overwrite / path traversal
* Lưu trong public → có thể execute

## Good Example (Best Practice)

### 1. Validate upload error

```php
if ($file['error'] !== UPLOAD_ERR_OK) {
    throw new UploadException('Upload failed');
}
```

### 2. Validate size

```php
if ($file['size'] > 5 * 1024 * 1024) {
    throw new UploadException('Too large');
}
```

### 3. Validate MIME (quan trọng nhất)

```php
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
```

👉 Không dùng `$_FILES['type']`

### 4. Whitelist

```php
$allowed = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
];
```

### 5. Random filename

```php
$name = bin2hex(random_bytes(16)) . '.jpg';
```

👉 Không dùng tên user upload

### 6. Store outside web root

```php
/storage/uploads
```

👉 Không để trong public/

### 7. Serve qua controller

```php
readfile($path);
```

👉 Có thể check permission

## Giải thích sâu (Senior mindset)

### 1. RCE (Remote Code Execution)

Nếu upload `.php` vào public:

```php
http://example.com/uploads/shell.php
```

👉 Server execute code

### 2. Double extension attack

```bash
shell.php.jpg
```

👉 Bypass extension check

### 3. MIME spoofing

Client gửi:

```http
Content-Type: image/jpeg
```

👉 Fake được → phải dùng `finfo`

### 4. Path traversal

```bash
../../shell.php
```

👉 Dùng `basename()` để tránh

### 5. Storage strategy

* Public: chỉ static safe files
* Private: upload user

👉 Serve qua controller

## Tips & Tricks

### 1. Disable PHP execution trong uploads

```nginx
location /uploads {
    deny all;
}
```

### 2. Image re-encode

👉 Load và save lại image → loại bỏ payload

### 3. Virus scan

👉 Dùng ClamAV cho file quan trọng

### 4. Rate limit upload

👉 Tránh spam / DoS

### 5. Logging

👉 Log upload suspicious

## Interview Questions

<details>
  <summary>1. Tại sao upload file nguy hiểm?</summary>

**Summary:**

* Có thể dẫn tới RCE

**Deep:**
Upload file thực thi → server chạy code attacker

</details>

<details>
  <summary>2. Tại sao không check extension?</summary>

**Summary:**

* Dễ bypass

**Deep:**
Double extension hoặc rename file

</details>

<details>
  <summary>3. Tại sao không dùng MIME từ client?</summary>

**Summary:**

* Fake được

**Deep:**
Client control header

</details>

<details>
  <summary>4. Cách an toàn nhất để lưu file?</summary>

**Summary:**

* Random name + private storage

**Deep:**
Không public + serve qua controller

</details>

<details>
  <summary>5. Làm sao để tránh RCE?</summary>

**Summary:**

* Validate + không execute

**Deep:**
MIME check, store ngoài public, disable execution

</details>

## Kết luận

👉 File upload là CRITICAL security area

Nếu làm sai → mất server

👉 Luôn:

* Validate
* Random filename
* Store private
* Serve qua controller
