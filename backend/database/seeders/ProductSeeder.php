<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade if not already there

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'title' => 'Đặt hoa bó 20-10',
                'image' => 'http://localhost:8000/storage/products/hoa-bo-20-10.webp',
                'category' => 'hoa-bo',
                'description' => NULL,
                'style' => NULL,
                'tag' => 'hoa bó 20-10',
                'is_on_top' => 0,
            ],
            [
                'id' => 2,
                'title' => 'Đặt hoa bó babi – 0966183183',
                'image' => 'http://localhost:8000/storage/products/hoa-bo-babi.webp',
                'category' => 'hoa-bo',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => NULL,
                'tag' => 'hoa bó babi',
                'is_on_top' => 0,
            ],
            [
                'id' => 3,
                'title' => 'Đặt Hoa Bó Hồng Đỏ 0966183183',
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-do.webp',
                'category' => 'hoa-bo',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => NULL,
                'tag' => 'hoa bó hồng đỏ',
                'is_on_top' => 0,
            ],
            [
                'id' => 4,
                'title' => 'Đặt hoa bó hồng kem 0966183183',
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-kem.webp',
                'category' => 'hoa-bo',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => NULL,
                'tag' => 'hoa bó hồng kem',
                'is_on_top' => 0,
            ],
            [
                'id' => 5,
                'title' => 'Đặt hoa bó tone vàng 0966183183',
                'image' => 'http://localhost:8000/storage/products/hoa-bo-tone-vang.webp',
                'category' => 'hoa-bo',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => NULL,
                'tag' => 'hoa bó tone vàng',
                'is_on_top' => 0,
            ],
            [
                'id' => 6,
                'title' => 'Hoa Khai Trương – Shop hoa gần nhất',
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-QF.webp',
                'category' => 'hoa-khai-truong',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Hoa khai trương là món quà dành tặng người thân,bạn bè ,đối tác với ý nghĩa lời chúc tốt đẹp dành cho họ trong bước đầu sự nghiệp hồng phát làm ăn phát đạt thành công.',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa khai trương',
                'is_on_top' => 1,
            ],
            [
                'id' => 7,
                'title' => 'Hoa Khai Trương Hiện Đại',
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-11.webp',
                'category' => 'hoa-khai-truong',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => 'mau-hien-dai',
                'tag' => 'hoa khai trương hiện đại',
                'is_on_top' => 1,
            ],
            [
                'id' => 8,
                'title' => 'Hoa Khai Trương Truyền Thống',
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-truyen-thong-2.webp',
                'category' => 'hoa-khai-truong',
                'description' => 'Chọn mua hoa mừng khai trương truyền thống chưa bao giờ dễ dàng hơn khi bạn tham khảo các sản phẩm tại hệ thống Quỳnh Flowers',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa khai trương truyền thống',
                'is_on_top' => 1,
            ],
            [
                'id' => 9,
                'title' => 'Đặt Hoa Đám Tang Bà Rịa Vũng Tàu 0966183183',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Hoi-Nghia.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Vòng  hoa đám tang Bà Rịa  với thiết kế 2 tầng tone màu tím chủ đạo',
                'style' => 'mau-truyen-thong',
                'tag' => NULL,
                'is_on_top' => 0,
            ],
            [
                'id' => 10,
                'title' => 'Đặt Hoa Đám Tang Biên Hòa 0966183183',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Long-Phuoc.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
 Hoa đám tang Biên Hòa – Điện hoa tang lễ Thành Phố Biên Hòa',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa đám tang biên hoà',
                'is_on_top' => 0,
            ],
            [
                'id' => 11,
                'title' => 'Đặt Hoa Đám Tang Dĩ An 0966183183',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Thu-Dau-Mot.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Bạn cần gửi  hoa đám tang Dĩ An thì việc chọn và đặt hoa tại Quỳnh Flowers là điều quá dễ dàng',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa đám tang dĩ an',
                'is_on_top' => 0,
            ],
            [
                'id' => 12,
                'title' => 'Đặt Hoa Đám Tang Mỹ Tho 0966183183',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Hiep-An.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa đám tang Mỹ Tho',
                'is_on_top' => 0,
            ],
            [
                'id' => 13,
                'title' => 'Hoa đám tang tiễn đưa – SH01',
                'image' => 'http://localhost:8000/storage/products/Hoa-dam-tang-tien-dua-SH01.webp',
                'category' => 'hoa-dam-tang',
                'description' => 'Hoa đám tang tiễn đưa như lời chia sẽ nổi buồn cùng gia quyến mong người ở lại hãy mạnh mẽ.',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa đám tang tiễn đưa',
                'is_on_top' => 1,
            ],
            [
                'id' => 14,
                'title' => 'Hoa đám tang tone tím – SH02',
                'image' => 'http://localhost:8000/storage/products/Hoa-dam-tang-tone-tim.webp',
                'category' => 'hoa-dam-tang',
                'description' => 'Vòng luân hồi của sinh lão bệnh tử luôn xoay quanh và mẫu hoa đám tang tone tím được nhiều KH chọn lựa.',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa đám tang tone tím',
                'is_on_top' => 0,
            ],
            [
                'id' => 15,
                'title' => 'Hoa đám tang tone trắng – SH03',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Long-Phuoc.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => 'mau-truyen-thong',
                'tag' => 'hoa đám tang tone trắng',
                'is_on_top' => 0,
            ],
            [
                'id' => 16,
                'title' => 'Đặt Hoa Đám Tang Đồng Xoài O966183138',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Phuong-An-Phu.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Vòng  hoa đám tang Đồng Xoài chính là thông điệp âm thầm bày tỏ sự đồng cảm chia sẻ đến người đã khuất',
                'style' => 'mau-hien-dai',
                'tag' => 'hoa đám tang Đồng Xoài',
                'is_on_top' => 0,
            ],
            [
                'id' => 17,
                'title' => 'Đặt Hoa Đám Tang Tân An 0966183183',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Thai-Hoa.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Quỳnh Flowers luôn luôn tạo nên sự an tâm khi đặt  hoa đám tang Tân An',
                'style' => 'mau-hien-dai',
                'tag' => 'hoa đám tang tân an',
                'is_on_top' => 0,
            ],
            [
                'id' => 18,
                'title' => 'Đặt Hoa Đám Tang Tây Ninh 0966183183',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Tan-An.webp',
                'category' => 'hoa-dam-tang',
                'description' => 'Với mẫu hoa đám tang Tây Ninh mang phong cách hiện đại nhìn sẽ mới lạ mắt hơn nhưng cũng không kém phần trang trọng',
                'style' => 'mau-hien-dai',
                'tag' => 'hoa đám tang tây ninh',
                'is_on_top' => 0,
            ],
            [
                'id' => 19,
                'title' => 'Hoa đám tang chia xa – SH04',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-BIEN-HOA.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => 'mau-hien-dai',
                'tag' => 'hoa đám tang chia xa',
                'is_on_top' => 0,
            ],
            [
                'id' => 20,
                'title' => 'Hoa Đám Tang Hiện Đại',
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Hien-Dai4.webp',
                'category' => 'hoa-dam-tang',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
 Hoa đám tang hiện đại  sẽ là bước ngoặc của những kệ hoa tang hoàn toàn mới thay cho mẫu truyền thống theo năm tháng.',
                'style' => 'mau-hien-dai',
                'tag' => 'hoa đám tang hiện đại',
                'is_on_top' => 1,
            ],
            [
                'id' => 21,
                'title' => 'Hoa Đám Tang Công Giáo',
                'image' => 'http://localhost:8000/storage/products/hoa-dam-tang-cong-giao-2.webp',
                'category' => 'hoa-dam-tang',
                'description' => 'Cây thánh giá được coi là biểu tượng thiêng liêng của người Công Giáo.
<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => 'hoa-dam-tang-cong-giao',
                'tag' => 'hoa đám tang công giao',
                'is_on_top' => 1,
            ],
            [
                'id' => 22,
                'title' => 'Đặt Hoa Giỏ Dĩ An 0966183183',
                'image' => 'http://localhost:8000/storage/products/hoa-gio-di-an.webp',
                'category' => 'hoa-gio',
                'description' => 'Đặt Hoa Giỏ Dĩ An – Shop Hoa Tươi Gần Nhất – 0966183183
<ul>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Quỳnh Flowers luôn luôn tạo nên sự an tâm khi đặt  hoa đám tang Tân An',
                'style' => NULL,
                'tag' => 'hoa giỏ dĩ an',
                'is_on_top' => 0,
            ],
            [
                'id' => 23,
                'title' => 'Đặt Hoa Giỏ Phú Nhuận 0966183183',
                'image' => 'http://localhost:8000/storage/products/hoa-gio-phu-nhuan.webp',
                'category' => 'hoa-gio',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => NULL,
                'tag' => 'hoa giỏ phú nhuận',
                'is_on_top' => 0,
            ],
            [
                'id' => 24,
                'title' => 'Đặt Hoa Giỏ Tân Phú 0966183183',
                'image' => 'http://localhost:8000/storage/products/hoa-gio-tan-phu.webp',
                'category' => 'hoa-gio',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>',
                'style' => NULL,
                'tag' => 'hoa giỏ tân phú',
                'is_on_top' => 0,
            ],
            [
                'id' => 25,
                'title' => 'Hoa Giỏ – Shop Hoa gần nhất',
                'image' => 'http://localhost:8000/storage/products/hoa-gio-1.webp',
                'category' => 'hoa-gio',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
 Hoa Giỏ  xinh dễ dàng phối cùng mọi loại hoa, từ cao sang như lan, hồng màu tươi sáng, hoa ly kép..',
                'style' => NULL,
                'tag' => 'hoa giỏ',
                'is_on_top' => 0,
            ],
            [
                'id' => 26,
                'title' => 'Hoa Bó – Shop Hoa Gần Đây',
                'image' => 'http://localhost:8000/storage/products/hoa-bo-1.webp',
                'category' => 'hoa-bo',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Quỳnh Flowers hệ thống hoa tươi đã phủ rộng khắp 63 tỉnh thành vì vậy việc chuyển hoa sẽ rất linh hoạt tránh để bó hoa di chuyển quá xa làm ảnh hưởng đến chất lượng',
                'style' => NULL,
                'tag' => 'hoa bó',
                'is_on_top' => 1,
            ],
            [
                'id' => 27,
                'title' => 'Hoa Bó hồng đỏ lãng mạn',
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-do-21.webp',
                'category' => 'hoa-bo',
                'description' => '<ul>
  <li>Shop Hoa Tươi Gần Nhất – 0966183183</li>
  <li>Cam kết hoa tươi, cắm trong ngày, chất lượng.</li>
  <li>Luôn gửi hình ảnh mẫu hoa trước và sau khi giao</li>
  <li>Giao hoa nhanh chóng, chỉ trong vòng 1 đến 2 giờ kể từ khi chốt đơn hàng</li>
  <li>Miễn phí thiết kế băng chữ theo ý quý khách</li>
  <li>Hình thức thanh toán dễ dàng thuận tiện.</li>
  <li>Giao hàng miễn phí tại các quận nội thành trong thành phố</li>
</ul>
Hoa bó hồng đỏ được coi là loài hoa của tình yêu, đó là lý do tại sao hoa hồng đỏ là món quà phổ biến trong ngày lễ tình nhân.',
                'style' => NULL,
                'tag' => 'hoa bó hồng đỏ',
                'is_on_top' => 0,
            ],
        ]);
    }
}
