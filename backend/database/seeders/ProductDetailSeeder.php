<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade if not already there

class ProductDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_details')->insert([
            [
                'id' => 1,
                'product_id' => 1,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-20-10.webp',
                'title' => 'Hoa Bó 20-10 nhân ngày  20/10',
                'intro' => 'Ngày 20/10 món quà ý nghĩa giành cho người phụ nữ tuyệt vời nhất của Bạn.   <a href=\"/danh-muc/hoa-bo/\" target=\"_blank\">Hoa bó 20-10</a> món quà thể hiện lòng yêu thương cho người phụ nữ xinh đẹp.<br>',
                'description' => 'Mỗi bó hoa hay mỗi bông hoa sẽ mang một ý nghĩa khác nhau, với mẫu hoa hồng phấn cùng điểm với hoa đệm và lá sẽ làm tôn vinh những màu sắc của bó hoa 20-10.<br><br>

  Ngày Phụ nữ Việt Nam 20/10 là ngày đầu tiên trong lịch sử nước ta, một đoàn thể quần chúng của phụ nữ được hoạt động hợp pháp và công khai, nhằm đoàn kết, động viên lực lượng phụ nữ đóng góp tích cực vào sự nghiệp cách mạng của đất nước.<br><br>

  Ngày nay con cái có quyền tham gia bàn bạc cùng cha mẹ những vấn đề của gia đình. Tòng phụ cũng không còn là ép duyên, bán gả con gái. Hôn nhân ngày nay được xây dựng trên cơ sở tình yêu tự nguyện. Tòng phu ngày nay cũng không nhất thiết người con dâu phải sống chung cùng gia đình nhà mẹ chồng. Vì thế hệ trẻ ngày nay năng động và đầy tính tự lập. Hơn nữa hình mẫu gia đình hạt nhân đang có chiều hướng phát triển mạnh. Mẹ không nhất thiết phải ở với con trai. Tất cả đã được pháp luật, sự tiến bộ của nhận thức quy định và bảo vệ…',
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-babi.webp',
                'title' => 'Hoa bó babi dễ thương vì sao ?',
                'intro' => NULL,
                'description' => 'Mỗi hoa sẽ có một sắc thái và ý nghĩa khác nhau, vơi hoa bó babi thì ý nghĩa cũng không kém so với các loại hoa thông dụng.',
            ],
            [
                'id' => 3,
                'product_id' => 2,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-babi-diem-hong.webp',
                'title' => NULL,
                'intro' => NULL,
                'description' => 'Những cánh hoa babi nhập khẩu dù bé xíu nhưng phần điểm tô khá làm cho người nhận chối từ. Với màu chủ yếu là hoa trắng kết hợp cùng giấy gói màu đen càng thêm nổi bật. Bên cạnh màu trắng chủ đạo thì hoa bó babi cũng có sự linh hoạt màu sắc.',
            ],
            [
                'id' => 4,
                'product_id' => 2,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-babi-size-lon.webp',
                'title' => NULL,
                'intro' => NULL,
                'description' => 'Bên cạnh những hoa bó babi xinh xinh thì bó babi size to cũng được nhiều khách hang ưu chuộng bởi độ hoành tráng của bó hoa. Ưu điểm của hoa babi là có thể để khô và chưng ở những vị trí đẹp do độ bền hoa khi đã khô.',
            ],
            [
                'id' => 5,
                'product_id' => 3,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-do.webp',
                'title' => 'Hoa Bó Hồng Đỏ',
                'intro' => 'Khi một bó hoa được trao tặng đến người yêu thương đúng lúc và kịp thời vào những dịp quan trọng như ngày lễ tình nhân 14/2, ngày quốc tế phụ nữ 8/3, ngày phụ nữ Việt Nam 20/10… thì  hoa bó hồng đỏ .',
                'description' => 'Với hoa bó hồng đỏ màu chủ đạo của những việc quan trọng những lúc tỏ tình thì tone màu đỏ được khá nhiều khách hàng chọn lựa. Màu sắc của hoa hồng sẽ phụ thuộc vào nhiều yếu tố quan trọng hơn hết nó sẽ là màu của người nhận ưa thích thì ý nghĩa của hoa bó hồng đỏ càng được nâng cao.<br><br>

  Điểm tô cho màu đỏ của hoa hồng thì không thể phủ nhận vai trò của giấy bó là yếu tố góp phần tạo nên hoa bó hồng đỏ thêm xinh tươi.<br><br>

  Trên đây là những chia sẻ sơ bộ cho việc chọn một bó hoa tặng cho người thương vào những dịp quan trọng. Quỳnh Flowers luôn sẵn sàng giúp Bạn chuyển đi những bó hoa hồng xinh nhất.',
            ],
            [
                'id' => 6,
                'product_id' => 4,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-kem.webp',
                'title' => 'Hoa bó hồng kem xinh tươi',
                'intro' => 'Bó hoa xinh tươi và đáng yêu sẽ được tạo nên bởi nhiều yếu tố tạo thành. Với Hoa bó hồng kem thì độ dịu ngọt và bánh bèo của em nó thể hiện ngay những cánh hoa và giấy gói.',
                'description' => 'Niềm vui có lẽ không thể không nhân đôi khi hoa bó hồng kem được trao tặng đúng dịp đúng người tạo nên sự bất ngờ cho người nhận. Hãy trao nhau những kỉ niệm đẹp nhất vào những ngày điểm nhấn của hẹn hò.<br><br>

  Sự duyên dáng của hoa bó hồng kem không nằm ngoài sự xen lẫn của cỏ đồng tiền yếu tố phụ tạo nên bó hoa xinh tươi. Ngoài ra Bạn cũng nên nhắn gửi lời chúc cho thêm phần lãng mạn giúp người nhận cảm thấy hưng phấn hơn.',
            ],
            [
                'id' => 7,
                'product_id' => 5,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-tone-vang.webp',
                'title' => 'Hoa bó tone vàng tạo nên sự thoải mái',
                'intro' => 'Với  hoa bó tone vàng  màu vàng còn mang tới nhiều may mắn trong phong thủy. Sắc vàng ấm áp tựa mặt trời tượng trưng cho năng lượng tích cực, giúp không gian trở nên ấm cúng, giảm bớt cảm giác u ám xung quanh.',
                'description' => 'Màu vàng của sự tươi sáng, hạnh phúc, ấm áp, là loài hoa biểu tượng cho tình bạn chân thành, không vụ lợi. Đây còn là lời chúc may mắn, tốt lành tới những người thương yêu nhất của bạn. Vì vậy nên hoa bó tone vàng được chọn nhiều hơn vào những dịp phù hợp nhất. <br> 

Ngoài ra, hoa hồng màu vàng còn đặc biệt dành cho người mẹ kính yêu thể hiện lòng biết ơn, tôn kính của phận làm con. Nhanh tay đặt ngay hoa bó tone vàng để thể hiện lòng tôn kính với những người yêu thương của mình thông qua zalo 0966183183.',
            ],
            [
                'id' => 8,
                'product_id' => 6,
                'image' => NULL,
                'title' => 'Hoa khai trương là gì?',
                'intro' => NULL,
                'description' => 'Hoa Khai Trương món quà cũng mang đến nhiều ý nghĩa cho người thân bạn bè, đối tác trong bước đầu sự nghiệp. Mong chúc cho họ khai trương hồng phát làm ăn phát đạt và gặt hái được nhiều thành công.<br>
Chọn hoa khai trương để chúc mừng bạn bè, đối tác, đồng nghiệp hay người thân trong dịp khai trương nói dễ mà cũng không phải dễ. Vậy tặng như thế nào cho đúng ?
',
            ],
            [
                'id' => 9,
                'product_id' => 6,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong.webp',
                'title' => 'Chọn hoa khai trương đúng và ý nghĩa.',
                'intro' => NULL,
                'description' => 'Ngày khai trương là ngày quan trọng, nó như là trang giấy đầu tiên của cuốn sách, đánh dấu cột mốc của công ty, doanh nghiệp, shop bán hàng bắt đầu xây dựng sự nghiệp. Do vậy, nếu đóng vai trò là bạn bè, đối tác, khách hàng, người thân… hãy chọn cho mình mẫu hoa khai trương đúng và mang ý nghĩa tuyệt vời nhất, giúp buổi lễ thành công tốt đẹp. <br>
* Xem các mẫu Hoa Khai Trương.',
            ],
            [
                'id' => 10,
                'product_id' => 6,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-1.webp',
                'title' => 'Chọn màu sắc của hoa khai trương tươi sáng tỏa nắng.',
                'intro' => NULL,
                'description' => 'Chọn màu sắc của hoa cũng là một trong những điều bạn nên để ý, tránh chọn sai màu, ảnh hưởng đến không khí ngày khai trương. Cách an toàn và tốt nhất khi tặng hoa khai trương cho người khác là ưu tiên chọn màu đỏ hoặc màu vàng.<br>
Màu đỏ mang đến sự may mắn, còn màu vàng là tượng trưng cho sự thành công, phát tài. Dù chọn loài hoa nào, bạn cũng cần để ý đến màu sắc nhé!',
            ],
            [
                'id' => 11,
                'product_id' => 6,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-13.webp',
                'title' => 'Chọn loài hoa mang sự may mắn, thịnh vượng.',
                'intro' => NULL,
                'description' => 'Một số loài hoa mang đến sự may mắn, thịnh vượng được nhiều người ưa chuộng trong dịp khai trương như: <br> <br>

Hoa hướng dương: Đối với ngày lễ khai trương, hoa hướng dương biểu tượng sự hướng thượng, hướng đến nhiều sự tốt đẹp và thành công trong tương lai. Một giỏ hoa hướng dương chúc mừng khai trương được gửi đến cho người khác, đó cũng là lời chúc cho khởi đầu làm ăn thuận lợi, phát tài, phát lộc.<br> <br>

Hoa đồng tiền: không chỉ mang ý nghĩa về tiền tài, mà loài hoa này còn mang đến may mắn và lộc lá cho chủ doanh nghiệp, cửa hàng. Với ý nghĩa đó, hoa đồng tiền trở thành một trong những loài hoa không thể thiếu đối với list hoa khai trương.<br> <br>

Lan Hồ Điệp: vẻ đẹp của hoa Lan rất tinh tế và nhẹ nhàng, nó thể hiện được sự sang trọng và thành công trong cuộc sống, công việc. Một chậu Lan Hồ Điệp tặng cho người thân trong ngày khai trương sẽ là món quà đúng và mang ý nghĩa thiết thực nhất.<br> <br>

Hồng Môn: hồng môn có rất nhiều màu sắc, trong đó màu đỏ thích hợp để tặng vào dịp khai trương, với mong muốn người nhận sẽ khai trương hồng phát, gặp được nhiều thuận lợi trong công việc sắp tới.',
            ],
            [
                'id' => 12,
                'product_id' => 6,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-11.webp',
                'title' => 'Một số mẫu hoa khai trương cực đẹp.',
                'intro' => NULL,
                'description' => 'Giỏ hoa khai trương <br>
Một giỏ hoa khai trương nhỏ rất thích hợp để bàn trang trí, với thiết kế nhệ nhàng nhưng cũng không kém phần rực rỡ là lời chúc cho khởi đầu làm ăn thuận lợi, phát tài, phát lộc. <br><br>

Kệ hoa khai trương <br>
Kệ hoa mang đến sự sang trọng và giúp không gian trở nên hoành tráng hơn bao giờ hết. <br><br>

Lẵng hoa 2 tầng<br>
Lẵng hoa 2 tầng cũng là mẫu hoa cực kì hot được nhiều người lựa chọn với những thiết kế vô cùng độc đáo, đa dạng và sự sang trọng, ý nghĩa mà nó đem tới.<br><br>
Chậu hoa<br>
Đối với những người thân, người mình gần gũi thì có lẽ chậu hoa để bàn sẽ phù hợp nhất. Vì chúng sẽ sống và phát triển theo thời gian, cùng với đó là sự chăm sóc của chủ nhân. Do vậy, chậu hoa mang ý nghĩa vô cùng đặc biệt, giúp tình cảm giữa hai bên trở nên khăng khít hơn. <br><br>

Như vậy chúng ta đã biết cách chọn hoa khai trương thế nào cho đúng và phù hợp rồi đúng không? Hãy nhớ rằng, chọn hoa mang ý nghĩa của sự may mắn, thành công và thịnh vượng để truyền tải đúng thông điệp mình muốn gửi đến cho họ nhé!',
            ],
            [
                'id' => 13,
                'product_id' => 7,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-2.webp',
                'title' => 'Hoa khai trương hiện đại xu thế mới của ngành hoa',
                'intro' => NULL,
                'description' => 'Hoa khai trương hiện đại sẽ là mẫu hoa được khá nhiều khách hàng trẻ khách hàng theo xu hướng mới chọn lựa. Với mẫu kệ hoa khai trương hiện đại thì nét bay bổng của kệ hoa chúc mừng cùng với phần hoa lá đệm cũng phong phú hơn thay gì chỉ sử dụng lá cau truyền thống.',
            ],
            [
                'id' => 14,
                'product_id' => 7,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-1-1.webp',
                'title' => NULL,
                'intro' => NULL,
                'description' => NULL,
            ],
            [
                'id' => 15,
                'product_id' => 7,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-11.webp',
                'title' => 'Mẫu hoa khai trương hiện đại được thiết kế thế nào ?',
                'intro' => 'Với những nét mới trong cách phối hoa và cách trang trí kệ hoa thì mẫu hoa khai trương hiện đại sẽ rất mới mẽ bởi cái nhìn đầu tiên. Những tấm giấy gói hoa được thiết kế như một công chúa bánh bèo cho kệ chúc mừng thêm phần sinh động. Cụ thể của sự sinh động và bánh bèo là đây.',
                'description' => NULL,
            ],
            [
                'id' => 16,
                'product_id' => 7,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-112.webp',
                'title' => 'Sự cầu kì trong cách thiết kế của hoa khai trương hiện đại:',
                'intro' => 'Với các tone màu nóng và nổi bật để kệ  hoa khai trương hiện đại  luôn nổi bật như góp phần chúc cho gia chủ một ngày khai trương thật hồng phát, thuận buồm xuôi gió, vạn sự hanh thông.',
                'description' => 'Không nằm ngoài hay đơn lẽ bởi cái nhìn lạ mắt so với các kệ hoa truyền thống thì  hoa khai trương hiện đại   cũng khá trau chuốt và chỉnh chu theo một cách riêng. Với mỗi kệ hoa chúc mừng thì tone màu hay loại hoa cũng là nét chung tạo nên một kệ hoa chúc mừng đẹp.',
            ],
            [
                'id' => 17,
                'product_id' => 7,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-13.webp',
                'title' => NULL,
                'intro' => NULL,
                'description' => 'Tone màu của  hoa khai trương hiện đại  sẽ khá đa dạng bởi sự phối hợp của nhiều loại hoa, sự đan xen vào nhau giữa nhiều loại hoa.',
            ],
            [
                'id' => 18,
                'product_id' => 7,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-hien-dai-14.webp',
                'title' => NULL,
                'intro' => NULL,
                'description' => 'Trên đây là đôi chút sơ bộ về hoa chúc mừng khai trương để có thể chọn được mẫu hoa ưng ý và phù hợp nhất cho những dịp quan trọng Quý khách vui lòng nhắn trực tiếp cho zalo 0966183183 Quỳnh Flower sẽ giúp Bạn hoàn thành những chọn lựa hoa chúc mừng.',
            ],
            [
                'id' => 19,
                'product_id' => 8,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-truyen-thong-2.webp',
                'title' => 'Hoa khai trương truyền thống cái nhìn quen thuộc của hoa chúc mừng',
                'intro' => NULL,
                'description' => NULL,
            ],
            [
                'id' => 20,
                'product_id' => 8,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-truyen-thong-1-1.webp',
                'title' => NULL,
                'intro' => 'Màu sắc của kệ hoa chúc mừng theo kiểu truyền thống sẽ ưa nhìn bởi mức độ quen thuộc trong cuộc sống hằng ngày. Với thiết kế mang phong cách cổ điển nhưng vẫn phải trau chuốt và tỉ mỉ. Sự kết hợp của nhiều màu sắc hoa trên kệ  hoa khai trương truyền thống  sẽ làm cho kệ thêm rực rỡ tone tươi mới.',
                'description' => NULL,
            ],
            [
                'id' => 21,
                'product_id' => 8,
                'image' => 'http://localhost:8000/storage/products/hoa-khai-truong-truyen-thong-22.webp',
                'title' => 'Nên chọn mẫu hoa khai trương truyền thống cho dịp khai trương ?',
                'intro' => 'Bạn dễ dàng chọn các mẫu hoa khai trương truyền thống với gam màu nóng được thiết kế từ các loại hoa tươi phổ biến: Hoa hồng đỏ, hoa hồng tím, hoa đồng tiền, hoa lan đỏ, hoa hướng dương,…Các màu sắc tươi tắn, rực rỡ rất phù hợp với không gian buổi lễ chúc mừng khai trương.<br>
Để các lẵng hoa hoặc kệ  hoa chúc mừng khai trương nhìn tinh tế và sang trọng. Bạn nên ghi kèm lời chúc ngắn gọn, chân thành và ý nghĩa trước khi gửi món quà này tới người nhận.',
                'description' => NULL,
            ],
            [
                'id' => 22,
                'product_id' => 9,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Hoi-Nghia.webp',
                'title' => 'Hoa Đám Tang Bà Rịa Vũng Tàu',
                'intro' => 'Hoa đám tang hay hoa tang lễ được sử dụng vào dịp tiễn đưa người mất về bên kia, hoa viếng cũng chính là lời nguyện cầu mong cho người mất sớm được siêu thoát.',
                'description' => ' Hoa đám tang Bà Rịa  luôn được giao tận nơi và miễn phí ship khu vực Thành Phố Bà Rịa , với các khu vực lân cận thì  Quỳnh Flowers  có nhận vận chuyển tận nơi. Với khu vực lân cận Thành Phố Bà Rịa sẽ có những khoản phí ship tùy vào độ xa hay gần.<br> <br>

Vòng  hoa đám tang Bà Rịa với thiết kế 2 tầng tone màu tím chủ đạo sẽ giúp người gửi hoa như phàn nào san sẽ nổi buồn cùng gia quyến ngay ngày tang gia.',
            ],
            [
                'id' => 23,
                'product_id' => 10,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Long-Phuoc.webp',
                'title' => 'Hoa Đám Tang Biên Hòa',
                'intro' => ' Hoa đám tang Biên Hòa – Điện hoa tang lễ Thành Phố Biên Hòa sẽ giúp bạn chuyển hoa viếng tại Biên Hòa và các khu vực lân cận.',
                'description' => 'Ngày nay việc đặt hoa đám tang sẽ trở nên dễ dàng và thuận tiện hơn rất nhiều chỉ thao tác trên zalo là có ngay hoa tang lễ tại nơi cần giao. Với lợi thế hoa nhập mới mỗi ngày và kệ  hoa đám tang  sẽ được cắm khi khách hàng đã chốt đơn nên thời gian chưng hoa sẽ được lâu và hoa cũng tươi mới hơn.

Đến với dịch vụ điện hoa tươi online Quỳnh Flowers thì Bạn hoàn toàn yên tâm bởi uy tín và chất lượng hoa luôn là tiêu chí hàng đầu. Ngoài việc cung cấp  hoa đám tang Biên Hòa  thì Quỳnh Flowers sẽ giúp Bạn chuyển hoa viếng đi khắp 63 tỉnh thành với hệ thống cửa hàng hoa toàn quốc.',
            ],
            [
                'id' => 24,
                'product_id' => 11,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Thu-Dau-Mot.webp',
                'title' => 'Hoa Đám Tang Dĩ An:',
                'intro' => 'Quỳnh Flowers tại Bình Dương sẽ giúp Bạn chuyển hoa đám tang Dĩ An với chất lượng được đảm bảo do vị trí cửa hàng ngay trung tâm của Thành Phố Dĩ An.',
                'description' => 'Trong cuộc sống hằng ngày con người ta không thể nào ra khỏi vòng luân hồi ” sinh lão bệnh tử” chính vì vậy việc gửi hoa tang lễ mẫu truyền thống cũng sẽ không là ngoại lệ.<br><br>

Khi Bạn cần gửi  hoa đám tang Dĩ An  thì việc chọn và đặt hoa tại Quỳnh Flowers là điều quá dễ dàng bởi chúng em có nhận chuyển khoản cho khách hàng ở xa. Về chất lượng hoa và thời gian giao hoàn toàn chủ động do chúng em luôn gửi hình ảnh hoa tại nơi giao để khách hàng an tâm là hoa đã được gửi đến đúng lúc.',
            ],
            [
                'id' => 25,
                'product_id' => 12,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Hiep-An.webp',
                'title' => 'Hoa Đám Tang Mỹ Tho:',
                'intro' => 'Người xưa nói “Nghĩa tử là nghĩa tận.” Trong hoàn cảnh tang gia bối rối, nỗi buồn bất tận của sự chia ly vĩnh viễn thì lẵng hoa chia buồn, vòng hoa tang lễ chính là thông điệp âm thầm bày tỏ sự đồng cảm đến người đã khuất cũng như toàn bộ gia quyến.
<br><br>
Với mẫu hoa đám tang Mỹ Tho sẽ phần nào san sẽ được nổi đau cùng gia quyến, mong người ra đi sớm được siêu thoát.',
                'description' => 'Đi cùng thiết kế 3 tầng của kệ  hoa đám tang Mỹ Tho  khi Bạn gửi đến chia buồn thì cũng phần nào giúp cho tang lễ thêm phần long trọng bởi kệ hoa cũng khá đồ sộ.
<br><br>
Sự kết hợp giữa những hoa lan và hoa cúc tạo nên kệ  hoa đám tang Mỹ Tho  thêm phần thanh khiết giúp kệ hoa tang lễ mang một ý nghĩa tuyệt vời nhất.',
            ],
            [
                'id' => 26,
                'product_id' => 13,
                'image' => NULL,
                'title' => 'Hoa đám tang tiễn đưa mẫu hoa thiết kế theo kiểu truyền thống.',
                'intro' => NULL,
                'description' => 'Với mẫu hoa mang đậm chất truyền thống của người việt sẽ dễ dàng bắt gặp tai đa số các đám tang khu vực miền trung trở vào miền nam.  Hoa đám tang tiễn  đưa như phần nào chia sẽ nổi buồn cùng gia quyến.',
            ],
            [
                'id' => 27,
                'product_id' => 13,
                'image' => 'http://localhost:8000/storage/products/Hoa-dam-tang-tone-tim-1.webp',
                'title' => 'Sự hài hòa của mẫu hoa đám tang tiễn đưa',
                'intro' => NULL,
                'description' => 'Đôi lúc cuộc sống với bộn bề lo toang đã hối thúc con người chạy theo những xu thế mới nhưng với hoa tang lễ mẫu truyền thống cũng sẽ mãi tồn tại với thời gian bởi đâu đó mẫu hoa đám tang tiễn đưa đã gắn bó khá lâu trong suy nghĩ người Việt. Tone  hoa tang lễ  chủ đạo màu tím đan sen với những hoa màu khác giúp kệ hoa viếng thêm cân đối.',
            ],
            [
                'id' => 28,
                'product_id' => 13,
                'image' => 'http://localhost:8000/storage/products/Hoa-dam-tang-tone-tim-2.webp',
                'title' => 'Hoa đám tang tiễn đưa có nhiều KH chọn ?',
                'intro' => NULL,
                'description' => 'Một mẫu hoa đám tang không quá đơn giản cũng không quá cầu kỳ sẽ được rất nhiều khách hàng chọn lựa bởi mức độ chỉnh chu của kệ hoa và giá thành cũng phù hợp với thời buổi kinh tế hiện nay. Chính vì đơn giản nhưng cũng không kém phần trang trọng nên mẫu  hoa đám tang tiễn  đưa được lựa chọn khá nhiều.',
            ],
            [
                'id' => 29,
                'product_id' => 14,
                'image' => NULL,
                'title' => 'Hoa đám tang tone tím chia sẽ nổi đau cùng gia quyến.',
                'intro' => NULL,
                'description' => 'Với mẫu thiết kế của  hoa đám tang tone  tím theo kiểu truyền thống như thể hiện sự chia sẽ nổi đau cùng gia quyến.  Hoa tang lễ  với tone hoa chủ đạo màu tím đã quá đỗi quen thuộc trong các tang lễ của người việt.',
            ],
            [
                'id' => 30,
                'product_id' => 14,
                'image' => 'http://localhost:8000/storage/products/Hoa-dam-tang-tone-tim-2.webp',
                'title' => 'Sự gắn kết hài hòa hoa đám tang tone tím',
                'intro' => NULL,
                'description' => 'Vòng luân hồi của sinh lão bệnh tử dường như luôn xoay quanh và con người sẽ trãi qua các giai đoạn của nó. Với vòng  hoa đám tang tone tím  được thiết kế hai tầng và được phối đệm với hoa hồng vàng giúp kệ hoa tang lễ thêm nổi bật và như vơi đi phần nào của nổi buồn tuột cùng.',
            ],
            [
                'id' => 31,
                'product_id' => 14,
                'image' => 'http://localhost:8000/storage/products/Hoa-dam-tang-tone-tim-1.webp',
                'title' => 'Đặt hoa đám tang ở đâu giao nhanh nhất ?',
                'intro' => NULL,
                'description' => 'Trong lúc tang gia bối rối hay lúc Bạn nhận được hung tin người thân đã đi xa thì việc chọn lựa mẫu hoa đám tang hay việc tìm đơn vị cung cấp hoa viếng có giao tận nơi là nổi lo toang ngay lúc này. Hãy gọi ngay cho Quỳnh Flower với hệ thống cửa hàng tại 63 tỉnh thành Việt Nam sẽ giúp Bạn chu tất mọi việc.',
            ],
            [
                'id' => 32,
                'product_id' => 15,
                'image' => NULL,
                'title' => 'Hoa đám tang tone trắng có được ưa chuộng ?',
                'intro' => NULL,
                'description' => 'Với sắc hoa màu trắng sẽ rất hài hòa với phong cảnh tại tang lễ như khăn tang, áo tang…  Hoa đám tang tone trắng  như một bức tranh buồn của ngày tiễn đưa nhưng phần nào cũng gửi lời chia buồn đến gia quyến',
            ],
            [
                'id' => 33,
                'product_id' => 15,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Long-Phuoc.webp',
                'title' => 'Vòng hoa đám tang tone trắng thuần khiết',
                'intro' => NULL,
                'description' => 'Một kệ hoa tone trắng được thiết kế một cách chỉnh chu từ đầu tới chân kệ càng thể hiện tấm lòng thành của người gửi hoa chia buồn. Vòng tròn hoa lan trắng như thể hiện của vòng luân hồi cầu mong người đã khuất sớm được luân hồi một kiếp khác an nhiên. <br> <br>
<i>Sản phẩm thực nhận có thể khác với hình đại diện trên website (đặc điểm thủ công và tính chất tự nhiên của hàng nông nghiệp)</i>',
            ],
            [
                'id' => 34,
                'product_id' => 15,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Uyen-Hung-1.webp',
                'title' => 'Sự kết hợp hài hòa của vòng hoa tang lễ',
                'intro' => NULL,
                'description' => 'Hài hòa cũng đâu đó là sự cố gắng kết hợp những cánh hoa tạo nên một kệ hoa với mức độ hài hòa cao nhất. Trên kệ  hoa đám tang tone trắng  được đẹp phải có sự kết hợp của hai hay nhiều loại hoa sẽ giúp kệ hoa trở nên đan sen các cánh hoa vào nhau.<br><br>

Hãy trải nghiệm chất lượng hoa và chất lượng dịch vụ tại Quỳnh Flower – hệ thống hoa tươi toàn quốc.',
            ],
            [
                'id' => 35,
                'product_id' => 16,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Phuong-An-Phu.webp',
                'title' => 'Hoa Đám Tang Đồng Xoài:',
                'intro' => 'Điện hoa tươi Đồng Xoài Bình Phước có hệ thống cửa hàng hoa tươi tại 63 tỉnh thành nên việc giao hoa đám tang Đồng Xoài.<br><br>

Người xưa nói “Nghĩa tử là nghĩa tận.” Trong hoàn cảnh tang gia bối rối, nỗi buồn bất tận của sự chia ly vĩnh viễn thì lẵng hoa chia buồn, vòng hoa tang lễ chính là thông điệp âm thầm bày tỏ sự đồng cảm đến người đã khuất cũng như toàn bộ gia quyến.',
                'description' => 'Vòng hoa đám tang Đồng Xoài chính là thông điệp âm thầm bày tỏ sự đồng cảm chia sẻ đến người đã khuất cũng như toàn bộ gia quyến. Ở một phương diện nào đó, vòng hoa đám tang được ví như sứ giả của niềm hy vọng để động viên tinh thần gia quyến người đã khuất vượt qua nỗi đau.',
            ],
            [
                'id' => 36,
                'product_id' => 17,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Thai-Hoa.webp',
                'title' => 'Hoa Đám Tang Tân An mẫu đẹp:',
                'intro' => 'Với thiết kế đẹp mắt mẫu hoa đám tang Tân An luôn được nhiều khách hàng chọn lựa bởi độ trau chuốt của sản phẩm.',
                'description' => 'Ngày nay việc gửi điện hoa chia buồn đã trở nên quá thông dụng chính vì thấu hiểu được việc chọn lựa đơn vị uy tín và chất lượng nên Quỳnh Flowers luôn luôn tạo nên sự an tâm khi đặt hoa đám tang Tân An bởi chính uy tín sẽ tạo nên thương hiệu Quỳnh Flowers.<br><br>

Một kệ  hoa đám tang Tân An  được xem là đẹp bởi có nhiều yếu tố tạo nên kệ hoa tang lễ đẹp bao gồm: độ tươi mới của hoa, sự kết hợp các loại hoa cho phù hợp với phong tục và vùng miền, chân kệ được quấn lụa chỉnh chu, banner được thiết kế cho phù hợp nội dung viếng….',
            ],
            [
                'id' => 37,
                'product_id' => 18,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Tan-An.webp',
                'title' => 'Hoa Đám Tang Tây Ninh:',
                'intro' => 'Cửa hàng  hoa đám tang Tây Ninh  tọa lạc ngay trục đường CMT8 Thành Phố Tây Ninh nên việc giao hoa sẽ rất thuận tiện. Shop Quỳnh Flowers luôn sẳn sàng cắm những mẫu hoa đám tang cho phù hợp nhất với lễ viếng.',
                'description' => 'Với mẫu  hoa đám tang Tây Ninh  mang phong cách hiện đại nhìn sẽ mới lạ mắt hơn nhưng cũng không kém phần phần trang trọng. Tone màu trắng chủ đạo sẽ giúp kệ hoa viếng tone màu trắng thêm phần thuần khiết như thể hiện tấm lòng người ở lại.<br><br>

Cách phối hoa của mẫu hoa đám tang bên trên sẽ nhìn rất sang trọng bởi những hoa lan hồ điệp điểm nhấn của kệ  hoa đám tang Tây Ninh .',
            ],
            [
                'id' => 38,
                'product_id' => 19,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-BIEN-HOA.webp',
                'title' => 'Hoa đám tang chia xa',
                'intro' => NULL,
                'description' => ' Hoa đám tang chia xa  mẫu hoa với tone trắng của hoa và tone màu đen của giấy tạo nên một vòng hoa tang lễ mang phong cách hiện đại và lạ mắt.<br><br>

Những nhánh lan trắng được phối cùng với những bông hồng trắng chủ đạo sẽ tạo nên sản phẩm kệ hoa tang lễ hài hòa, nhẹ nhàng. Điểm nhấn của kệ hoa có lẽ nằm ngay chiếc nơ trắng ngay trung tâm tạo cân bằng trong phối hoa.<br><br>

Thành phần hoa tạo nên kệ  hoa đám tang chia xa  bao gồm: hoa lan thái trắng, hoa hồng trắng, hoa cẩm tú cầu, cỏ đồng tiền….Một khung cảnh buồn của tang lễ sẽ không lạc lỏng khi kệ hoa viếng đi với tone màu chủ đạo trắng và đen. Hãy trao cho nhau những gì cuối cùng trước khi rời xa.<br><br>

<h4>Mẫu hoa đám tang chia xa:</h4>
Được thiết kế mang phong cách hiện đại và trẻ trung, mẫu hoa đám tang chia xa sẽ giúp Bạn có cái nhìn mới hơn về hoa tang lễ thay gì những nét cổ điển thường ngày.<br><br>

Hoa đám tang hiện đại<br><br>

<h4>Đặt hoa đám tang ở đâu ?</h4>
Bạn có nhu cầu cần đặt mẫu hoa đám tang chia xa chỉ việc nhắn zalo chúng em sẽ giúp Bạn gửi hoa đám tang đến tận nơi và gửi hình ảnh xác nhận hoa đã được giao tại đám<br><br>

Quỳnh Flower hệ thống hoa tươi toàn quốc<br><br>

<h4>Chi phí mua vòng hoa đám tang</h4>
Với một chi phí vừa phải mẫu hoa đám tang chia xa sẽ đáp ứng nhu cầu gửi hoa viếng dạng phổ thông. <br><br>

Vòng hoa đám tang chia xa sẽ phù hợp với người mang phong cách hiện đại bởi cái nhìn về thiết kế sẽ phù hợp.',
            ],
            [
                'id' => 39,
                'product_id' => 20,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Hien-Dai4.webp',
                'title' => 'Hoa Đám Tang Hiện Đại là gì?',
                'intro' => NULL,
                'description' => ' Hoa đám tang hiện đại  theo xu hướng và trào lưu của các nước phương tây chính vì vậy mẫu kệ hoa tang lễ hiện đại sẽ nhìn với một nét hoàn toàn mới.  Hoa đám tang hiện đại  sẽ là bước ngoặc của những kệ hoa tang hoàn toàn mới thay cho mẫu truyền thống theo năm tháng.',
            ],
            [
                'id' => 40,
                'product_id' => 20,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Dinh-Hoa.webp',
                'title' => 'Phong cách cắm của hoa đám tang hiện đại',
                'intro' => NULL,
                'description' => 'Ảnh hưởng bới phong cách cắm hiện đại của phương tây nên kệ  hoa đám tang hiện đại  đôi lúc nhìn sẽ lạ mắt đồng thời cũng sẽ khác biệt so với các kệ hoa truyền thống tại đám tang. Đôi khi lượng hoa trên kệ hoa cũng sẽ không thật sự dầy dặn nhưng nét bay bổng hiện đại sẽ được mẫu sẽ là yếu tố giúp kệ hoa đám tang hiện đại trở nên khác biệt. Xoay quanh những chọn lựa loại hoa hay phong cách cắm cũng tất cả chỉ giành cho tấm lòng thành của người ở lại tiễn đưa người đi về nơi vĩnh hằng.',
            ],
            [
                'id' => 41,
                'product_id' => 20,
                'image' => 'http://localhost:8000/storage/products/Dat-Hoa-Dam-Tang-Chanh-My.webp',
                'title' => NULL,
                'intro' => ' Hoa đám tang hiện đại  mẫu hoa khá nhiều khách hàng chọn lựa tại những Thành Phố lớn bởi nét mới mẽ của vòng hoa tang lễ.',
                'description' => NULL,
            ],
            [
                'id' => 42,
                'product_id' => 20,
                'image' => NULL,
                'title' => 'Giao nhanh hoa đám tang hiện đại:',
                'intro' => NULL,
                'description' => 'Đối với dịch vụ Điện Hoa : Chúng tôi luôn ý thức được rằng thời gian giao hàng nhanh quyết định đến chất lượng dịch vụ.<br>
Chính xác về thời gian: Thời gian giao hoa từ 60 phút đến 120 phút tại các TP trung tâm. Với các vùng tỉnh xa thời gian giao hoa có thể trên 120 phút.
Giao hoa tận nhà, tận tay, có giao bằng xe ô tô , có hình ảnh chụp cụ thể trước và ngay khi giao để quý khách đối chiếu.
<br><br>
Chúng tôi tự hào là đơn vị cung cấp hoa dám tang khắp 64 tỉnh thành của Việt Nam.<br>
Với đội ngũ thợ cắm hoa chuyên nghiệp lâu năm, năng động sáng tạo shop hoa chúng tôi luôn tạo ra những sản phẩm hoa độc đáo mang tính thẩm mỹ cao.<br>
Với nguồn hoa được cung cấp từ các nhà vườn trồng hoa uy tín, được chon lọc kỹ lưỡng.<br>
Khi bạn cần hoa viếng đám tang – Hãy gọi ngay cho chúng tôi 0966183183 mọi việc sẽ được giải quyết theo đúng yêu cầu của bạn một cách nhanh nhất.',
            ],
            [
                'id' => 43,
                'product_id' => 21,
                'image' => 'http://localhost:8000/storage/products/hoa-dam-tang-cong-giao-2.webp',
                'title' => 'Hoa Đám Tang Công Giáo',
                'intro' => 'Trong mỗi dân tộc tôn giáo Việt Nam đều tồn tại hình thức cúng bái, tổ chức lễ tang tiễn đưa người đã khuất với hy vọng linh hồn của người đó sẽ được siêu thoát về nơi cực lạc. So với những đám tang thường thấy thì tang lễ Công giáo có cách thức tổ chức tương đối khác biệt. Vì vậy  hoa đám tang công giáo  cũng sẽ có phần khác biệt và có những nét đặc trưng của công giáo.',
                'description' => NULL,
            ],
            [
                'id' => 44,
                'product_id' => 21,
                'image' => 'http://localhost:8000/storage/products/hoa-dam-tang-cong-giao-1-1.webp',
                'title' => 'Ý nghĩa của tang lễ công giáo và hoa đám tang công giáo:',
                'intro' => 'Trong cộng đồng người Kitô Giáo, khi một người mất đi thì gia đình sẽ tổ chức những nghi thức tang lễ Công giáo nhằm tiễn đưa người đã khuất về nơi an nghỉ cuối cùng chào đón linh hồn họ đến với thế giới mới sau khi họ đã mất với mong muốn:<br>
<ul>
<li>An ủi tinh thần người ở lại</li>
<li>Che chở cho linh hồn người vừa mất.</li>
</ul>',
                'description' => NULL,
            ],
            [
                'id' => 45,
                'product_id' => 21,
                'image' => 'http://localhost:8000/storage/products/hoa-dam-tang-cong-giao-2-1.webp',
                'title' => 'Nét đặc trưng của hoa đám tang công giáo:',
                'intro' => 'Gắn liền với hình ảnh quen thuộc tai thánh đường là ảnh thánh giá rất trang nghiêm thì trong mẫu  hoa đám tang công giáo  biểu tượng thánh giá cũng được chọn lựa hàng đầu.

',
                'description' => NULL,
            ],
            [
                'id' => 46,
                'product_id' => 21,
                'image' => 'http://localhost:8000/storage/products/Hoa-Dam-Tang-Hoa-Tang-Le3.webp',
                'title' => NULL,
                'intro' => 'Bên cạnh những mẫu hoa đặc trưng cho công giáo thì mẫu hoa đám tang thông dụng cũng được sử dụng tại  đám tang công giáo . Suy cho cùng thì tấm lòng của người ở lại giành cho người ra đi sẽ là quan trọng, đôi khi kệ hoa viếng sẽ chọn tone màu hay loại hoa người mất thích điều này xem như thể hiện niềm tiếc thương vô hạn.',
                'description' => NULL,
            ],
            [
                'id' => 47,
                'product_id' => 21,
                'image' => 'http://localhost:8000/storage/products/hoa-dam-tang-cong-giao-23.webp',
                'title' => 'Màu sắc của hoa đám tang công giáo:',
                'intro' => 'Trong các lễ tang Đạo Công Giáo, màu trắng thường được sử dụng làm màu chủ đạo trên vòng hoa. Màu trắng tượng trưng cho sự trong sạch, tinh khiết cũng như sự đau buồn, tiếc thương của người ở lại dành cho người đã khuất. Trong Đạo Công Giáo, màu trắng còn mang ý nghĩa như sự phục sinh của chúa Kito, cũng như sự phục sinh của con người sau này.',
                'description' => 'Chúng tôi tự hào là đơn vị cung cấp hoa dám tang khắp 64 tỉnh thành của Việt Nam.
Với đội ngũ thợ cắm hoa chuyên nghiệp lâu năm, năng động sáng tạo shop hoa chúng tôi luôn tạo ra những sản phẩm hoa độc đáo mang tính thẩm mỹ cao.
Với nguồn hoa được cung cấp từ các nhà vườn trồng hoa uy tín, được chon lọc kỹ lưỡng.<br>
Khi bạn cần hoa viếng đám tang – Hãy gọi ngay cho chúng tôi 0966183183 mọi việc sẽ được giải quyết theo đúng yêu cầu của bạn một cách nhanh nhất.',
            ],
            [
                'id' => 48,
                'product_id' => 22,
                'image' => 'http://localhost:8000/storage/products/hoa-gio-di-an.webp',
                'title' => 'Mẫu hoa giỏ dĩ an được nhiều khách hàng chọn lựa',
                'intro' => 'Xoay quanh những mẫu hiện đại thì mẫu hoa quốc dân được nhiều khách hàng chọn lựa vào những dịp vui. Với mẫu hoa giỏ dĩ an đã quá quen thuộc.',
                'description' => 'Sự đơn giản nhưng vẫn thể hiện đầy đủ ý nghĩa của mẫu  hoa giỏ dĩ an  bởi các hoa hồng được chọn lọc và được bày trí một cách ưa nhìn. Các hoa babi cũng góp phần gắn kết giữa hai màu hoa hồng với nhau tạo thêm điểm nhấn bởi các hoa lá đệm.',
            ],
            [
                'id' => 49,
                'product_id' => 23,
                'image' => 'http://localhost:8000/storage/products/hoa-gio-phu-nhuan.webp',
                'title' => 'Làm sao chọn được mẫu hoa giỏ phú nhuận đẹp nhất',
                'intro' => 'Mẫu hoa giỏ đẹp sẽ được tạo bởi nhiều yếu tố, tiêu chí hàng đầu vẫn là hoa tươi mới và tay nghề của thợ cắm.  Hoa giỏ phú nhuận  được tạo bởi những bông hoa tone vàng mới nhất tạo nên.',
                'description' => 'Chủ đạo là hoa hồng vàng với những bông hoa vừa chóm nở và vẫn còn e ấp bên cánh lụa chưa kịp bung. Sự phối hợp giữa hồng vàng hoa hồng trứng đan sen hoa hướng dương và vài loại hoa phụ tạo nên bức phối khá hoan hảo cho  hoa giỏ phú nhuận .<br><br>

Với tay nghề của thợ nhiều năm kinh nghiệm và kỉ năng làm nghề hoa cũng khá lâu nên việc chon những bông hoa tone vàng thật đẹp trước khi được cắm vào giỏ.',
            ],
            [
                'id' => 50,
                'product_id' => 24,
                'image' => 'http://localhost:8000/storage/products/hoa-gio-tan-phu.webp',
                'title' => 'Hoa Giỏ Tân Phú nơi sắc hoa tỏa sáng',
                'intro' => 'Với thiết kế theo lối ưa nhìn nên hoa giỏ tân phú có cái nhìn khá quen mắt và được ưa chuộng hơn. Màu sắc có sự đan sen giữa hoa màu đỏ và hoa hồng vàng.',
                'description' => 'Sắp đến những dịp quan trọng Bạn nên lưu tâm và đặt hoa sớm hơn ngày cần hoa để shop có sự chuẩn bị chu đáo nhất. Với đặt thù giỏ hoa cần phải được cắm một cách chi tiết làm sao thể hiện chiều sâu của giỏ hoa, cũng bởi đặc thù là sản phẩm thủ công được tạo 100% bằng tay nên mức độ giống mẫu hoa giỏ tân phú sẽ ở mức tương đối và đồng thời hoa trong tự nhiên sẽ có dáng hoa khác nhau.',
            ],
            [
                'id' => 51,
                'product_id' => 25,
                'image' => 'http://localhost:8000/storage/products/hoa-gio.webpp',
                'title' => 'Hoa giỏ xinh đẹp :',
                'intro' => ' Hoa giỏ  xinh đẹp sẽ làm cho người nhận cảm thấy một cái gì đó phấn khích và cảm xúc khi nhận. Không những tạo ra vẽ đẹp bên ngoài mà giỏ hoa tươi còn đem đến luồng gió mới tưới mát không gian và tâm hồn con người, níu giữ lại những giây phút yên ả của cuộc sống.<br><br>
Để chọn được một  hoa giỏ  ưng ý cho phòng khách, văn phòng, bàn tiếp tân hay dành tặng ai đó..là cả một nghệ thuật. Đến với  Quỳnh Flowers  Khách hàng như lạc vào thế giới của hoa giỏ, ta dễ dàng bắt gặp những thiết kế đặc trưng trên nền giỏ nhựa, giỏ mây, hay lục bình.',
                'description' => 'Và mỗi chất liệu lại đem đến một nét riêng không dễ gì nhầm lẫn. Nếu giỏ hoa với sắc màu trắng, nâu thường gặp đem đến sự nhẹ nhàng, tinh khôi như màu áo nữ sinh lúc tan trường thì giỏ hoa màu nổi lại ẩn chứa nhiều tâm tình sâu lắng và màu nhạt mang đến nét mộc yên bình. Tùy theo cá tính hay sở thích mà chọn  hoa giỏ  phù hợp.',
            ],
            [
                'id' => 52,
                'product_id' => 25,
                'image' => 'http://localhost:8000/storage/products/hoa-gio-1.webp',
                'title' => 'Hoa giỏ xinh cho những cảm xúc bất tận',
                'intro' => ' Hoa Giỏ  xinh dễ dàng phối cùng mọi loại hoa, từ cao sang như lan, hồng màu tươi sáng, hoa ly kép.. Giỏ hoa chỉ độc nhất một loại hoa hay đôi khi là sự pha trộn của nhiều sắc thái khác nhau bên tầng lá xanh đều đẹp. Nếu bạn yêu thích sự đơn giản, chiếc giỏ nhựa chở đầy Thạch Thảo tím cũng đủ gọi về những mộng mơ. Với cô nàng cá tính thì việc chọn giỏ mây với sắc đỏ Hạnh Phúc bên Lan vàng làm quà tặng là điều dễ hiểu..',
                'description' => NULL,
            ],
            [
                'id' => 53,
                'product_id' => 25,
                'image' => 'http://localhost:8000/storage/products/hoa-gio-2.webp',
                'title' => NULL,
                'intro' => 'Nếu chọn cho bàn làm việc, một giỏ hoa bé bé xinh xinh được xem là nguồn năng lượng để bắt đầu ngày mới. Còn với những khách sạn, nhà hàng lớn..giỏ hoa ấy phải xứng tầm, không cần quá lớn nhưng yêu cầu toát lên được nét sang trọng, kiêu sa của mình.',
                'description' => 'Hãy gọi ngay cho  Quỳnh Flower  hệ thống hoa tươi toàn quốc sẽ giúp Bạn chuyển đi những thông điệp hoa tươi nhanh nhất .',
            ],
            [
                'id' => 54,
                'product_id' => 26,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-1.webp',
                'title' => 'Hoa bó món quà dễ thương:',
                'intro' => 'Khi nhắc đến những dịp quan trọng, những cuộc gặp mặt những lúc hẹn hò thì hoa bó là sự lựa chọn góp phần tạo nên không gian lãng mạng. Cũng khá bất ngờ cho đối phương khi Bạn vừa xuất hiện cùng với một bó hoa thật xinh và đáng yêu.',
                'description' => 'Bạn nghĩ gì khi tặng cho người mình yêu mình thương một  bó hoa  thật dịu ngọt như gói gém tất cả tình cảm vào đấy. Với những cách bố trí tưởng chừng mộc mạt nhưng lại rất kute thu hút người ấy ngay khi chạm vào.',
            ],
            [
                'id' => 55,
                'product_id' => 26,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-1-1.webp',
                'title' => 'Tone màu của hoa bó có khác nhau về nội dung:',
                'intro' => 'Với rất nhiều tone màu hoa để bạn chọn lựa, có rất nhiều sự lựa chọn nào là màu người được tặng ưa thích, màu phong thủy, màu theo mùa chẳng hạn như hoa 14/2….',
                'description' => NULL,
            ],
            [
                'id' => 56,
                'product_id' => 26,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-2.webp',
                'title' => NULL,
                'intro' => 'Không đâu xa vời với mẫu  hoa bó  màu xanh của cúc mẫu đơn như phần nào nói lên thuộc về phong thủy, sự đáng yêu của những bông hoa kết hợp cùng với lá bạc, cỏ đồng tiền như tô điểm thêm xinh cho bó hoa.
Với tone màu được khá nhiều khách hàng chọn lựa của mẫu hoa bó thì màu đỏ của hoa hồng luôn tồn tại theo năm tháng mà chẳng bao giờ được xem là lỗi thời.',
                'description' => NULL,
            ],
            [
                'id' => 57,
                'product_id' => 25, // Note: This product_id is 25, not 26. Check your original SQL for correctness.
                'image' => 'http://localhost:8000/storage/products/hoa-bo-3.webp',
                'title' => 'Xu thế của những mẫu hoa bó to và đậm chất hiện đại',
                'intro' => ' Hoa bó  được các nhà thiết kế tạo ra với những kiểu dáng và hình dạng khác nhau cũng giống như trong cuộc sống với muôn vàng cá tính của con người. Mỗi người sẽ có cái nhìn khác nhau về hoa tươi nhưng suy cho cùng đâu đó thì mẫu hoa bó dạng to vẫn chiếm lĩnh thị phần bởi vẻ lực lưỡng của nó.',
                'description' => NULL,
            ],
            [
                'id' => 58,
                'product_id' => 26,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-4.webp',
                'title' => NULL,
                'intro' => 'Đôi lúc những hoa bibi nhỏ nhắn nhưng khi kết hợp lại chúng lại vô cùng khác biệt trong cái nhìn của chúng ta. Điểm to thêm những sắc màu khác cho hoa bibi thì bên cạnh màu chủ đạo tone trắng của hoa bibi sẽ có những màu biến tấu tạo cho chúng ta cảm giác mới lạ của mẫu  hoa bó .',
                'description' => NULL,
            ],
            [
                'id' => 59,
                'product_id' => 26,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-5.webp',
                'title' => 'Có quá nhiều sự lựa chọn cho mẫu hoa bó:',
                'intro' => 'Một bó hoa xinh theo cảm nhận của từng người sẽ có những kiểu mẫu khác nhau, với tone màu sáng ( tone vàng) cũng được chú ý nhiều hơn trong những dịp mà Bạn cần tư vấn hoa màu vàng thì Quỳnh Flowers sẽ giúp Bạn lựa chọn và bố trí sao cho phù hợp nhất.',
                'description' => 'Tất cả những tone màu cách bày trí giấy gói hay banner chữ thì Bạn không phải quá bận tâm bởi chúng em đã có kinh nghiệm lâu năm trong việc thiết kế bó hoa phù hợp. Mọi việc đã có  Quỳnh Flowers  lo chu tất khi hệ thống hoa tươi đã phủ rộng khắp 63 tỉnh thành vì vậy việc chuyển hoa sẽ rất linh hoạt tránh để bó hoa di chuyển quá xa làm ảnh hưởng đến chất lượng.<br>
Hãy cho  Quỳnh Flowers  cơ hội được phục vụ hoa tươi nhanh nhất..',
            ],
            [
                'id' => 60,
                'product_id' => 27,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-2.webp',
                'title' => 'Hoa bó hồng đỏ là biểu tượng của sự lãng mạn trong tình yêu',
                'intro' => 'Màu đỏ của hoa hồng thể hiện cho tình cảm sâu đậm mà bạn dành cho người ấy. Để bày tỏ và thổ lộ tình cảm với đối phương thì đây quả là món quà valentine ý nghĩa. 
<h4>Hoa bó hồng đỏ dùng để bày tỏ thông điệp gì :</h4>',
                'description' => 'Mẫu  bó hoa hoa hồng  đỏ gắn liền với truyền thuyết vị nữ thần tình yêu, chính vì thế nên loài hoa này được xem như một biểu tượng của tình yêu nồng nàn và mãnh liệt với nhiều cung bậc cảm xúc khác nhau.<br><br>

Chính vì lẽ đó nên các cặp đôi thường xuyên lựa chọn hoa hồng đỏ để thể hiện tình yêu và trao cho nhau lời hẹn ước mãi mãi bên nhau dẫu có bất kì gian nan, khó khăn, thử thách nào cản đường.<br><br>

Đối với những cặp đôi đã cùng nhau vượt qua bao thăng trầm, sóng gió trong cuộc đời hoặc những cặp đôi đã cưới thì mẫu bó hoa hồng đỏ lại được xem như một sợi dây giúp gắn kết tình cảm của cả hai thêm lâu bền và giúp khơi lại những cảm xúc yêu đương cháy bỏng, nồng nàn như những ngày đầu mới yêu.',
            ],
            [
                'id' => 61,
                'product_id' => 27,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-do.webp',
                'title' => 'Hồng đỏ mang ý nghĩa của sự hoàn mỹ',
                'intro' => NULL,
                'description' => 'Trong nền văn hoá phương Tây, phái mạnh thường dùng vẻ đẹp của hoa hồng đỏ để miêu tả cho sắc đẹp của người phụ nữ đầy thu hút và quyến rũ. Chính vì thế nên họ thường xuyên dùng mẫu bó hoa hồng đỏ để tặng cho những cô gái mà mình có thiện cảm, để thay cho lời tán dương và khen ngợi vẻ đẹp của họ.<br><br>

Không chỉ tượng trưng cho một tình yêu lãng mạn, nồng nàn, cháy bỏng và ngọt ngào của lứa đôi, hình ảnh  bó hoa hồng đỏ  còn dùng để miêu tả sự hoàn mỹ của vẻ đẹp người con gái. Nếu như bạn muốn khen ngợi một cô gái có vẻ đẹp hoàn mỹ, vậy thì một bó hoa hồng đỏ sẽ giúp bạn làm được điều đó.',
            ],
            [
                'id' => 62,
                'product_id' => 27,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-do-2.webp',
                'title' => 'Số lượng hoa hồng đỏ có ý nghĩa thế nào ?',
                'intro' => NULL,
                'description' => 'Ý nghĩa hoa hồng đỏ trong tình yêu phụ thuộc vào số lượng bông mà bạn gửi tặng.<br>
<ul>
<li>+ Nếu tặng 1 bông cho đối phương có nghĩa là bạn đang ngầm nói với nàng rằng: “Trong trái tim anh chỉ có mình em”.</li>

<li>+ Nếu tặng 2 bông là muốn truyền tải rằng: “Thế giới này chỉ có hai chúng ta”.</li>
<li>+ Nếu tặng 3 bông là muốn nói rằng: “Anh yêu em”.</li>

<li>+ Bó hoa hồng đỏ 4 bông là lời khẳng định “Yêu em từ trái tim”.</li>

<li>+ Bó hoa hồng đỏ có 6 bông tặng nàng là lời thì thầm vào tai nàng rằng: “Hãy tôn trọng nhau, yêu nhau và tha thứ cho nhau em nhé!</li>

<li>+ Với những chàng yêu đơn phương và muốn thổ lộ tình cảm cho chàng biết hãy tặng bó hoa 7 bông hồng đỏ với thông điệp “Anh đã yêu thầm trộm nhớ em từ rất lâu”.</li>

<li>+ Bó hoa hồng đỏ 8 bông chính là lời “cám ơn” em đã cùng gắn bó trên đoạn đường yêu.</li>

<li>+ Bó hoa hồng đỏ 9 bông như một lời khẳng định: “Anh yêu em mãi mãi”.</li>

<li>+ Bó hoa hồng đỏ 10 bông là sự tán dương trong tình yêu và muốn khẳng định với nàng rằng: “Tình đôi ta thập toàn thập mỹ”.</li>

<li>+ Bó hoa hồng đỏ 11 hoa là lời khẳng định rằng: “Một đời, một kiếp này anh chỉ yêu mình em”.</li>

<li>+ Bó hoa hồng đỏ 100 bông là cách chàng muốn nói với nàng rằng: “Anh dùng tất cả sinh mệnh này để yêu em”.</li>

<li>+ Bó hoa 999 hoa hồng đỏ đẹp nhất là lời hứa “Mãi mãi yêu em”.</li>
</ul>',
            ],
            [
                'id' => 63,
                'product_id' => 27,
                'image' => 'http://localhost:8000/storage/products/hoa-bo-hong-do-21.webp',
                'title' => 'Một số loại hoa hồng đỏ được ưa chuộng hiện nay',
                'intro' => NULL,
                'description' => 'Hồng đỏ ohara hiện nay cũng được khá nhiều khách hàng ưa chuộng bởi độ đẹp của bông khi chúng ta phối thành hoa bó. Về hình thức thì mặt hoa nhìn sẽ dầy hơn hoa hồng đỏ nội và đồng thời chúng cũng có mùi thơm rất đặc trưng làm cho người nhận bó hoa càng say đắm.<br><br>

Hoa hồng đỏ ohara được xem là biểu tượng của tình yêu, luôn nồng cháy và đỏ thắm. Vì thế mà hoa hồng rất được các cặp tình nhân chọn để tặng trong các dịp lễ, tỏ tình và chúc mừng sinh nhật. Với sứ điệp mang yêu thương đến cho cô gái.',
            ],
            [
                'id' => 64,
                'product_id' => 27,
                'image' => NULL,
                'title' => 'Ý nghĩa hoa hồng đỏ trong tình yêu',
                'intro' => 'Trong một mối quan hệ vừa mới bắt đầu thì việc tặng hoa hồng đỏ là cách thể hiện tình cảm chân thành của mình, mong muốn cho một tình yêu phát triển xa hơn và bền chặt.<br><br>

Trong tình yêu, tặng hoa hồng đỏ có ý nghĩa nhằm bày tỏ sự chân thành, mạnh mẽ và bất chấp mọi chông gai. Do đó, mà ảnh hoa hồng nhung đẹp xuất hiện rất nhiều trong ngày lễ tình yêu (14/2), để bạn tỏ tình, bày tỏ tình cảm của mình cho đối phương.<br><br>

Hoa hồng đỏ là loài hoa ẩn chứa nhiều điều thú vị. Không chỉ là loài hoa tượng trưng cho tình yêu mà còn mang nhiều thông điệp cao cả trong cuộc sống.<br>
Hoa hồng đỏ còn là biểu tượng của sự yêu thương, tình thân cao quý… Vì thế, hoa hồng đỏ thích hợp cho việc làm món quà tặng bạn bè, cha mẹ, anh chị, đồng nghiệp… nhân các dịp đặc biệt. Việc bạn gửi tặng bó hoa hồng đỏ thắm đến ai đó là bạn đang bày tỏ tình cảm chân thành, tình thương sâu sắc, cảm mến và sự quan tâm.<br>
Không những thế hoa hồng đỏ còn mang ý nghĩa của lòng biết ơn, sự cảm kích. Nếu bạn muốn cám ơn ai đó hoặc bày tỏ tình cảm trước sự cảm kích với nghĩa cử cao đẹp thì bó hoa hồng đỏ là sự lựa chọn hoàn hảo. Tặng một bó hoa hồng đỏ còn bộc lộ sự nhã nhặn, ngọt ngào, đầy tính nhân văn.',
                'description' => 'Trên đây là những chia sẽ sơ bộ cho việc chọn một  bó hoa  tặng cho người thương vào những dịp quan trọng.  Quỳnh Flowers  luôn sẳn sàng giúp Bạn chuyển đi những bó hoa hồng xinh nhất.',
            ],
        ]);
    }
}
