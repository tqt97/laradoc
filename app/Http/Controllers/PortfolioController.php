<?php

namespace App\Http\Controllers;

use App\Support\PrezetHelper;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    /**
     * Display the artistic portfolio landing page.
     */
    public function index(): View
    {
        $data = [
            'hero' => [
                'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=2000&q=80',
                'title' => 'NHƯ PHOTOGRAPHY',
                'subtitle' => 'Ghi lại những khoảnh khắc tĩnh lặng qua lăng kính phái đẹp',
            ],
            'about' => [
                'name' => 'Như',
                'role' => 'Nhiếp ảnh gia Nghệ thuật',
                'portrait' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80',
                'bio' => 'Chào bạn, tôi là Như. Với tôi, nhiếp ảnh không chỉ là việc bấm máy, mà là cách tôi gửi gắm tâm hồn và sự nhạy cảm của phái nữ vào từng khung hình. Tôi đam mê vẻ đẹp mềm mại, chân thực và sự kỳ diệu của ánh sáng tự nhiên.',
            ],
            'stories' => [
                [
                    'url' => 'https://images.unsplash.com/photo-1496440737103-cd596325d314?auto=format&fit=crop&w=800&q=80',
                    'title' => 'Phố thị lên đèn',
                    'desc' => 'Câu chuyện về ánh sáng và bóng tối giữa lòng thành phố.',
                    'images' => [
                        ['url' => 'https://images.unsplash.com/photo-1496440737103-cd596325d314?auto=format&fit=crop&w=1200&q=80', 'title' => 'Ánh đèn vàng'],
                        ['url' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=1200&q=80', 'title' => 'Nhịp sống đêm'],
                        ['url' => 'https://images.unsplash.com/photo-1514565131-fce0801e5785?auto=format&fit=crop&w=1200&q=80', 'title' => 'Đường phố rực rỡ'],
                    ],
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=800&q=80',
                    'title' => 'Paris trong tôi',
                    'desc' => 'Những góc nhỏ lãng mạn của kinh đô ánh sáng qua ống kính Như.',
                    'images' => [
                        ['url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tháp Eiffel buổi sớm'],
                        ['url' => 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?auto=format&fit=crop&w=1200&q=80', 'title' => 'Nhà thờ Đức Bà'],
                        ['url' => 'https://images.unsplash.com/photo-1511739001486-6bfe10ce785f?auto=format&fit=crop&w=1200&q=80', 'title' => 'Hoàng hôn bên sông Seine'],
                    ],
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
                    'title' => 'Ký ức vùng cao',
                    'desc' => 'Vẻ đẹp hoang sơ và tình người ấm áp nơi vùng cao.',
                    'images' => [
                        ['url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thung lũng mờ sương'],
                        ['url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Đỉnh núi hùng vĩ'],
                        ['url' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=1200&q=80', 'title' => 'Ruộng bậc thang vàng óng'],
                    ],
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=800&q=80',
                    'title' => 'Ngày chung đôi',
                    'desc' => 'Những khoảnh khắc hạnh phúc nhất trong ngày trọng đại.',
                    'images' => [
                        ['url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80', 'title' => 'Lễ đường trang trọng'],
                        ['url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=1200&q=80', 'title' => 'Nụ cười cô dâu'],
                        ['url' => 'https://images.unsplash.com/photo-1510076857177-7470076d4098?auto=format&fit=crop&w=1200&q=80', 'title' => 'Lời thề nguyện'],
                    ],
                ],
            ],
            'polaroids' => [
                ['url' => 'https://images.unsplash.com/photo-1516724562728-afc824a36e84?auto=format&fit=crop&w=800&q=80', 'title' => 'Phía sau ống kính', 'angle' => '-rotate-6'],
                ['url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80', 'title' => 'Khoảnh khắc chờ đợi', 'angle' => 'rotate-3'],
                ['url' => 'https://images.unsplash.com/photo-1590487988256-9ed24133863e?auto=format&fit=crop&w=800&q=80', 'title' => 'Ánh sáng studio', 'angle' => '-rotate-2'],
                ['url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=800&q=80', 'title' => 'Thiết bị của Như', 'angle' => 'rotate-6'],
                ['url' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=800&q=80', 'title' => 'Góc nhìn tự nhiên', 'angle' => '-rotate-12'],
                ['url' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', 'title' => 'Bình minh rực rỡ', 'angle' => 'rotate-12'],
                ['url' => 'https://images.unsplash.com/photo-1496440737103-cd596325d314?auto=format&fit=crop&w=800&q=80', 'title' => 'Phố đêm rực rỡ', 'angle' => '-rotate-3'],
                ['url' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=800&q=80', 'title' => 'Nhịp sống đô thị', 'angle' => 'rotate-6'],
            ],
            'socials' => [
                'facebook' => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'zalo' => 'https://zalo.me/your-zalo-id',
                'email' => 'hello@nhu.example',
            ],
            'cinematic' => [
                ['url' => 'https://images.unsplash.com/photo-1485846234645-a62644f84728?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cảnh quay số 01'],
                ['url' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cảnh quay số 02'],
                ['url' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cảnh quay số 03'],
                ['url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cảnh quay số 04'],
            ],
            'abstract' => [
                ['url' => 'https://images.unsplash.com/photo-1502691876148-a84978e59af8?auto=format&fit=crop&w=1200&q=80', 'title' => 'Hình khối & Màu sắc', 'speed' => 'data-scroll-speed="1"'],
                ['url' => 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?auto=format&fit=crop&w=1200&q=80', 'title' => 'Vũ điệu ánh sáng', 'speed' => 'data-scroll-speed="2"'],
                ['url' => 'https://images.unsplash.com/photo-1541701494587-cb58502866ab?auto=format&fit=crop&w=1200&q=80', 'title' => 'Góc nhìn trừu tượng', 'speed' => 'data-scroll-speed="1.5"'],
            ],
            'exhibitions' => [
                ['url' => 'https://images.unsplash.com/photo-1507676184212-d03ab07a01bf?auto=format&fit=crop&w=1200&q=80', 'title' => 'Triển lãm "Nắng Mai"', 'location' => 'Hà Nội, 2025', 'class' => 'md:col-span-2 md:row-span-2'],
                ['url' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=1200&q=80', 'title' => 'Góc nhìn Phố', 'location' => 'Sài Gòn, 2024', 'class' => 'md:col-span-1 md:row-span-1'],
                ['url' => 'https://images.unsplash.com/photo-1471341971476-ae15ff5dd4ad?auto=format&fit=crop&w=1200&q=80', 'title' => 'Ánh sáng Nội tâm', 'location' => 'Đà Lạt, 2024', 'class' => 'md:col-span-1 md:row-span-1'],
                ['url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=1200&q=80', 'title' => 'Kỹ thuật Hiện đại', 'location' => 'Huế, 2023', 'class' => 'md:col-span-2 md:row-span-1'],
            ],
            'comparison' => [
                'before' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=1200&q=80&sat=-100',
                'after' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?auto=format&fit=crop&w=1200&q=80',
            ],
            'services' => [
                ['title' => 'Chụp ảnh Cưới', 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z', 'desc' => 'Ghi lại trọn vẹn từng khoảnh khắc hạnh phúc nhất.'],
                ['title' => 'Chụp ảnh Chân dung', 'icon' => 'M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z', 'desc' => 'Tôn vinh vẻ đẹp cá nhân qua từng đường nét.'],
                ['title' => 'Chụp ảnh Sự kiện', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z', 'desc' => 'Lưu giữ những dấu mốc quan trọng của doanh nghiệp.'],
            ],
            'testimonials' => [
                [
                    'content' => 'Như không chỉ chụp ảnh, Như bắt trọn linh hồn của khoảnh khắc. Những bức ảnh cưới của chúng tôi mang một màu sắc điện ảnh và cảm xúc mà không lời nào tả xiết.',
                    'author' => 'Minh Anh & Hoàng Nam',
                    'role' => 'Khách hàng chụp ảnh cưới',
                ],
                [
                    'content' => 'Sự nhạy cảm với ánh sáng của Như thật sự khác biệt. Bộ ảnh chân dung thương hiệu của tôi nhận được rất nhiều lời khen ngợi về sự tinh tế và chuyên nghiệp.',
                    'author' => 'Lê Thảo Chi',
                    'role' => 'Founder of Bloom Creative',
                ],
                [
                    'content' => 'Quy trình làm việc cực kỳ thoải mái. Như biết cách khơi gợi cảm xúc tự nhiên nhất của người đứng trước ống kính.',
                    'author' => 'Trần Đăng Khoa',
                    'role' => 'Nghệ sĩ tự do',
                ],
            ],
            'featured' => [
                ['url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tình yêu vĩnh cửu', 'category' => 'Đám cưới'],
                ['url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tầm nhìn núi bình yên', 'category' => 'Phong cảnh'],
                ['url' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Linh hồn hoang dã', 'category' => 'Thiên nhiên'],
            ],
            'collections' => $this->getCollectionsData(),
        ];

        return view('portfolio.index', array_merge($data, [
            'seo' => PrezetHelper::getSeoData(
                'Nhu Photography | Capturing Quiet Moments',
                'Khám phá thế giới qua lăng kính của Như. Chuyên nghiệp, tinh tế và đầy cảm hứng.',
                null,
                $data['hero']['image']
            ),
        ], PrezetHelper::getCommonData()));
    }

    /**
     * Centralized data source for portfolio collections.
     */
    public function getCollectionsData(): array
    {
        return [
            'Landscapes' => [
                'name_vn' => 'Phong cảnh',
                'desc' => 'Hùng vĩ và tráng lệ của thiên nhiên hoang sơ.',
                'featured' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tầm nhìn núi bình yên', 'size' => 'col-span-2 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thiên nhiên tuyệt mỹ', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1200&q=80', 'title' => 'Hồ nước tĩnh lặng', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1200&q=80', 'title' => 'Rừng vàng mùa thu', 'size' => 'col-span-1 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thung lũng xanh mướt', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1200&q=80', 'title' => 'Bình minh trên biển', 'size' => 'col-span-1 row-span-1'],
                ],
            ],
            'Weddings' => [
                'name_vn' => 'Đám cưới',
                'desc' => 'Ghi lại những khoảnh khắc thiêng liêng nhất của lứa đôi.',
                'featured' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tình yêu vĩnh cửu', 'size' => 'col-span-2 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=1200&q=80', 'title' => 'Chú rể thanh lịch', 'size' => 'col-span-1 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1510076857177-7470076d4098?auto=format&fit=crop&w=1200&q=80', 'title' => 'Nụ hôn ngọt ngào', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=1200&q=80', 'title' => 'Điệu nhảy đầu tiên', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=1200&q=80', 'title' => 'Chi tiết nhẫn cưới', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tiệc cưới sang trọng', 'size' => 'col-span-1 row-span-1'],
                ],
            ],
            'Nature' => [
                'name_vn' => 'Thiên nhiên',
                'desc' => 'Vẻ đẹp thuần khiết và sự sống mãnh liệt của muôn loài.',
                'featured' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Linh hồn hoang dã', 'size' => 'col-span-2 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1200&q=80', 'title' => 'Buổi sáng mờ sương', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cánh đồng vàng', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1518495973542-4542c06a5843?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cây cổ thụ tỏa nắng', 'size' => 'col-span-1 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?auto=format&fit=crop&w=1200&q=80', 'title' => 'Lối mòn bằng gỗ', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1426604966848-d7adac402bff?auto=format&fit=crop&w=1200&q=80', 'title' => 'Đảo xanh giữa hồ', 'size' => 'col-span-1 row-span-1'],
                ],
            ],
            'Makeup' => [
                'name_vn' => 'Trang điểm',
                'desc' => 'Nghệ thuật tôn vinh vẻ đẹp tự nhiên và cá tính.',
                'featured' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=1200&q=80', 'title' => 'Sự thanh lịch nghệ thuật', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=80', 'title' => 'Vẻ đẹp hiện đại', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1522337660859-02fbefca4702?auto=format&fit=crop&w=1200&q=80', 'title' => 'Trang điểm mắt nghệ thuật', 'size' => 'col-span-2 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=1200&q=80', 'title' => 'Nét đẹp sắc sảo', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Vẻ đẹp thuần khiết', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thời trang & Làm đẹp', 'size' => 'col-span-1 row-span-1'],
                ],
            ],
            'Street' => [
                'name_vn' => 'Đường phố',
                'desc' => 'Nhịp sống hối hả và những góc khuất đầy tự sự.',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=1200&q=80', 'title' => 'Đêm thành thị', 'size' => 'col-span-2 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Bóng hình cô độc', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=1200&q=80', 'title' => 'Giao lộ ánh sáng', 'size' => 'col-span-1 row-span-1'],
                ],
            ],
            'Portraits' => [
                'name_vn' => 'Chân dung',
                'desc' => 'Khai thác chiều sâu tâm hồn qua ánh mắt và nụ cười.',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thanh xuân', 'size' => 'col-span-1 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=1200&q=80', 'title' => 'Gương mặt thời gian', 'size' => 'col-span-2 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=1200&q=80', 'title' => 'Ánh nhìn thuần khiết', 'size' => 'col-span-1 row-span-1'],
                ],
            ],
            'Fashion' => [
                'name_vn' => 'Thời trang',
                'desc' => 'Sự kết hợp hoàn mỹ giữa phong cách và nghệ thuật hình ảnh.',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?auto=format&fit=crop&w=1200&q=80', 'title' => 'Vogue Style', 'size' => 'col-span-2 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Xu hướng mới', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80', 'title' => 'Sắc màu sàn diễn', 'size' => 'col-span-1 row-span-1'],
                ],
            ],
            'BlackWhite' => [
                'name_vn' => 'Trắng đen',
                'desc' => 'Vẻ đẹp tối giản và vĩnh cửu của hai sắc thái đối lập.',
                'featured' => 'https://images.unsplash.com/photo-1552083375-1447ce847b45?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1516724562728-afc824a36e84?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tương phản', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tĩnh lặng', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?auto=format&fit=crop&w=1200&q=80', 'title' => 'Đường nét', 'size' => 'col-span-2 row-span-1'],
                ],
            ],
        ];
    }
}
