<?php

namespace App\Http\Controllers;

use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $collections = $this->getCollectionsData();
        return view('portfolio.index', array_merge([
            'collections' => $collections,
            'seo' => PrezetHelper::getSeoData('Bộ Sưu Tập Nghệ Thuật', 'Khám phá những khoảnh khắc nghệ thuật', null, 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80'),
        ], PrezetHelper::getCommonData()));
    }

    public function getCollectionsData(): array
    {
        return [
            'Landscapes' => [
                'desc' => 'Hùng vĩ và tráng lệ của thiên nhiên hoang sơ.',
                'featured' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tầm nhìn núi bình yên', 'size' => 'col-span-2 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thiên nhiên tuyệt mỹ', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1200&q=80', 'title' => 'Hồ nước tĩnh lặng', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&w=1200&q=80', 'title' => 'Rừng vàng mùa thu', 'size' => 'col-span-1 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thung lũng xanh mướt', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1200&q=80', 'title' => 'Bình minh trên biển', 'size' => 'col-span-1 row-span-1'],
                ]
            ],
            'Weddings' => [
                'desc' => 'Ghi lại những khoảnh khắc thiêng liêng nhất của lứa đôi.',
                'featured' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tình yêu vĩnh cửu', 'size' => 'col-span-2 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=1200&q=80', 'title' => 'Chú rể thanh lịch', 'size' => 'col-span-1 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1510076857177-7470076d4098?auto=format&fit=crop&w=1200&q=80', 'title' => 'Nụ hôn ngọt ngào', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?auto=format&fit=crop&w=1200&q=80', 'title' => 'Điệu nhảy đầu tiên', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?auto=format&fit=crop&w=1200&q=80', 'title' => 'Chi tiết nhẫn cưới', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1520854221256-17451cc331bf?auto=format&fit=crop&w=1200&q=80', 'title' => 'Tiệc cưới sang trọng', 'size' => 'col-span-1 row-span-1'],
                ]
            ],
            'Nature' => [
                'desc' => 'Vẻ đẹp thuần khiết và sự sống mãnh liệt của muôn loài.',
                'featured' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Linh hồn hoang dã', 'size' => 'col-span-2 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1200&q=80', 'title' => 'Buổi sáng mờ sương', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cánh đồng vàng', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1518495973542-4542c06a5843?auto=format&fit=crop&w=1200&q=80', 'title' => 'Cây cổ thụ tỏa nắng', 'size' => 'col-span-1 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1447752875215-b2761acb3c5d?auto=format&fit=crop&w=1200&q=80', 'title' => 'Lối mòn bằng gỗ', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1426604966848-d7adac402bff?auto=format&fit=crop&w=1200&q=80', 'title' => 'Đảo xanh giữa hồ', 'size' => 'col-span-1 row-span-1'],
                ]
            ],
            'Makeup' => [
                'desc' => 'Nghệ thuật tôn vinh vẻ đẹp tự nhiên và cá tính.',
                'featured' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=1200&q=80',
                'images' => [
                    ['url' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=1200&q=80', 'title' => 'Sự thanh lịch nghệ thuật', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?auto=format&fit=crop&w=1200&q=80', 'title' => 'Vẻ đẹp hiện đại', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1522337660859-02fbefca4702?auto=format&fit=crop&w=1200&q=80', 'title' => 'Trang điểm mắt nghệ thuật', 'size' => 'col-span-2 row-span-2'],
                    ['url' => 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=1200&q=80', 'title' => 'Nét đẹp sắc sảo', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b?auto=format&fit=crop&w=1200&q=80', 'title' => 'Vẻ đẹp thuần khiết', 'size' => 'col-span-1 row-span-1'],
                    ['url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80', 'title' => 'Thời trang & Làm đẹp', 'size' => 'col-span-1 row-span-1'],
                ]
            ],
        ];
    }
}
