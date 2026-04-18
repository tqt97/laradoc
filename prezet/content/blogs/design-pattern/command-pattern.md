---
title: "Command Pattern: Đóng gói tác vụ thành đối tượng"
excerpt: Biến một yêu cầu thực thi thành một đối tượng độc lập. Cách Laravel Jobs vận hành Command Pattern.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-command-pattern.webp
tags: [design-patterns, php, laravel, architecture]
---

## 1. Vấn đề

Bạn có các nút nhấn trong giao diện (Undo, Save, Delete). Mỗi nút làm việc khác nhau, việc hard-code hành động vào nút nhấn làm bạn khó thay đổi hoặc thêm bớt tính năng (ví dụ: Undo/Redo).

## 2. Định nghĩa

Command Pattern (Nhóm Behavioral) đóng gói một yêu cầu như một đối tượng, cho phép bạn tham số hóa các client với các request khác nhau, đưa vào queue hoặc thực hiện undo/redo.

## 3. Cách giải quyết

```php
interface Command { public function execute(); }

class SaveCommand implements Command {
    public function __construct(protected Document $doc) {}
    public function execute() { $this->doc->save(); }
}
```

## 4. Ứng dụng Laravel

**Laravel Jobs** chính là ứng dụng mạnh mẽ nhất của Command Pattern. Bạn đóng gói mọi thứ cần thiết (data, logic) vào class `Job`, cho phép đẩy vào Queue, thử lại (retry), hoặc thực thi sau đó.

## 5. Phỏng vấn

- **Q: Undo/Redo dùng pattern gì?** Command. Bạn chỉ cần lưu ngăn xếp (stack) các command đã thực thi và gọi `undo()` cho từng cái.
- **Q: Lợi ích lớn nhất là gì?** Decoupling giữa người yêu cầu (UI) và người thực thi (Service).

## 6. Kết luận

Command Pattern biến một hành động thành một "thứ" có thể cầm nắm, cất giữ, trì hoãn hoặc hoàn tác.
