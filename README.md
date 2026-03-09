# Laradoc 📚

[![Website](https://img.shields.io/badge/Website-tuantq.online-blue)](https://tuantq.online)
[![GitHub](https://img.shields.io/badge/GitHub-tqt97-black)](https://github.com/tqt97)
[![Repo](https://img.shields.io/badge/Repository-Laradoc-orange)](https://github.com/tqt97/laradoc)

![Laradoc Hero](screenshot-tuantq-online.png)

Laradoc là một nền tảng quản lý kiến thức (Knowledge Base) và blog cá nhân hiện đại, được thiết kế để giúp các lập trình viên lưu trữ và chia sẻ kinh nghiệm một cách có hệ thống. Dự án tập trung vào việc viết và quản lý nội dung thông qua Markdown, kết hợp với sức mạnh của hệ sinh thái Laravel.

## 🚀 Công nghệ sử dụng

Dự án được xây dựng với các công nghệ hiện đại nhằm đảm bảo hiệu năng và khả năng mở rộng:

* **Backend**: [Laravel 12+](https://laravel.com) - PHP Framework mạnh mẽ.
* **Engine**: [Prezet](https://prezet.com) - Thư viện quản lý nội dung Markdown cho Laravel.
* **Frontend**: [Tailwind CSS](https://tailwindcss.com) & [Blade](https://laravel.com/docs/blade) - Giao diện tùy biến, linh hoạt.
* **Markdown**: Hỗ trợ đầy đủ CommonMark, GitHub Flavored Markdown, và tích hợp Code Highlighting.

## 📸 Giao diện dự án

![Full Page Preview](tuantq.online.png)

## ✨ Tính năng nổi bật

| Tính năng                                                                                                                 | Mô tả                                                                        |
| :------------------------------------------------------------------------------------------------------------------------ | :--------------------------------------------------------------------------- |
| <img src="https://cdn.jsdelivr.net/npm/lucide-static@latest/icons/book-open.svg" width="22" height="22"> **Bài viết**     | Lưu trữ và chia sẻ kinh nghiệm thực chiến thông qua các bài viết chuyên sâu. |
| <img src="https://cdn.jsdelivr.net/npm/lucide-static@latest/icons/library.svg" width="22" height="22"> **Chuỗi bài viết** | Tổ chức nội dung theo lộ trình học tập và chủ đề cụ thể.                     |
| <img src="https://cdn.jsdelivr.net/npm/lucide-static@latest/icons/link.svg" width="22" height="22"> **Lưu trữ liên kết**  | Tổng hợp và phân loại các tài liệu, công cụ hữu ích từ internet.             |
| <img src="https://cdn.jsdelivr.net/npm/lucide-static@latest/icons/lightbulb.svg" width="22" height="22"> **Ý tưởng**      | Đóng góp và quản lý các ý tưởng bài viết mới từ cộng đồng.                   |
| <img src="https://cdn.jsdelivr.net/npm/lucide-static@latest/icons/code.svg" width="22" height="22"> **Snippets**          | Kho lưu trữ các đoạn mã nguồn ngắn, có thể tái sử dụng nhanh chóng.          |

## 📝 Hướng dẫn quản lý nội dung

### 1. Nội dung dựa trên tệp (Articles, Series, Snippets)

Các nội dung này được quản lý thông qua các tệp `.md` trong thư mục `prezet/content/`. Mặc dù có thể tạo qua giao diện Web, các tệp này vẫn sẽ được lưu trữ trực tiếp vào mã nguồn.

#### Metadata cho Bài viết (Article)

Đặt tại `prezet/content/blogs/*.md`

```yaml
---
title: "Tiêu đề bài viết"
date: YYYY-MM-DD
excerpt: "Mô tả ngắn gọn về nội dung bài viết"
image: /prezet/img/ogimages/blogs-slug.webp
tags: [laravel, php, tutorial]
---
```

#### Metadata cho Chuỗi bài viết (Series)

Đặt tại `prezet/content/series/[folder-name]/index.md`

```yaml
---
title: "Tiêu đề Series hoặc Bài viết trong Series"
excerpt: "Mô tả ngắn gọn"
category: "Tên danh mục (vd: Laravel)"
date: YYYY-MM-DD
order: 1
image: /prezet/img/ogimages/series-slug-index.webp
---
```

#### Quản lý Snippets

Snippets có thể được tạo nhanh qua giao diện tại `/snippets/create`. Khi tạo qua Web, hệ thống sẽ sinh ra tệp `.md` tại `prezet/content/snippets/` với cấu trúc:

```yaml
---
title: "Tên Snippet"
excerpt: "Mô tả ngắn"
date: YYYY-MM-DD
category: snippets
language: php # Hoặc javascript, bash, v.v.
---

```php
// Code của bạn ở đây
```

```

### 2. Nội dung dựa trên Database (Links, Ideas)
Quản lý trực tiếp thông qua giao diện người dùng (UI).

*   **Links**: Thêm tại `/links`. Dùng để lưu trữ nhanh các liên kết tài liệu.
*   **Ideas**: Đề xuất tại `/ideas`. Nơi cộng đồng gợi ý các chủ đề bài viết mới.

### 3. Tạo ảnh xem trước (OG Image)
Để bài viết có ảnh đại diện (Open Graph) chuyên nghiệp khi chia sẻ lên mạng xã hội, bạn nên tạo ảnh OG tương ứng.

*   **Tạo tự động**: Sử dụng lệnh Artisan để chụp ảnh màn hình từ URL của bài viết:
    ```bash
    # Tạo cho một bài viết cụ thể
    php artisan prezet:ogimage [slug]

    # Tạo cho tất cả các bài viết chưa có ảnh
    php artisan prezet:ogimage --all
    ```
*   **Vị trí lưu trữ**: Các ảnh được tạo sẽ được lưu tại thư mục: `prezet/images/ogimages/`.
*   **Quy tắc đặt tên**: Tên tệp ảnh nên trùng với slug của nội dung để dễ quản lý.
*   **Khai báo trong Frontmatter**: Sau khi tạo ảnh, hãy cập nhật đường dẫn vào metadata:
    ```yaml
    image: /prezet/img/ogimages/your-slug.webp
    ```

---

## 🤝 Hướng dẫn đóng góp (Contributing)

### Quy trình đóng góp
1. **Fork** dự án về tài khoản của bạn.
2. Tạo một **Branch** mới (`git checkout -b feature/amazing-content`).
3. **Commit** thay đổi và **Push** lên Branch của bạn.
4. Mở một **Pull Request (PR)** hướng về nhánh `master` của repository gốc.

### Quy trình phê duyệt
- Vui lòng chờ đợi chủ sở hữu repository ([tqt97](https://github.com/tqt97)) kiểm tra và đánh giá.
- PR sẽ được merge sau khi đạt yêu cầu về nội dung và kỹ thuật.

## 📬 Liên hệ

*   **Tác giả**: [tqt97](https://github.com/tqt97)
*   **Repository**: [tqt97/laradoc](https://github.com/tqt97/laradoc)
*   **Email**: [kutuanonline199@gmail.com](mailto:kutuanonline199@gmail.com)
*   **Website**: [tuantq.online](https://tuantq.online)

---
*Cảm ơn bạn đã tham gia xây dựng cộng đồng Laradoc!*
