<?php
declare(strict_types=1);

/*
 * ข้อมูลทริปทั้งหมดอยู่ที่ไฟล์นี้ไฟล์เดียว (ข้อความบนปุ่ม/เมนูอยู่ที่ data/ui.php)
 *
 * ข้อความที่แสดงบนเว็บเขียนเป็น 2 ภาษาแบบนี้:  ['en' => 'English', 'th' => 'ไทย']
 * ถ้าข้อความเหมือนกันทั้ง 2 ภาษา (เช่นชื่อร้าน) ใส่เป็นข้อความธรรมดาได้เลย
 *
 * image: 'unsplash:PHOTO_ID' (รูปจาก Unsplash) หรือ 'assets/images/ชื่อไฟล์.jpg' (รูปของคุณเอง)
 *
 * stops มี 2 แบบ
 *   สถานที่:    มี start, end, name, image ... (การ์ดใหญ่พร้อมรูป)
 *   จุดแวะสั้น: 'type' => 'note' มีแค่ time กับ text (เช่น รับที่โรงแรม)
 *
 * เวลา: รูปแบบ 24 ชม. "HH:MM" ระบบคำนวณระยะเวลาให้เอง
 */

return [
    'brand'  => 'HuaHin.Trip',
    'avatar' => 'H|T',
    'title'  => [
        'en' => 'Hua Hin to Sam Roi Yot in one day',
        'th' => 'หัวหิน – สามร้อยยอด 1 วัน',
    ],
    'tagline' => [
        'en' => 'A royal pavilion inside a cave, lunch on a fishing beach, and a slow boat through the lotus marsh under limestone peaks. We pick you up from your Hua Hin hotel at 8am and have you back by 6pm.',
        'th' => 'ถ้ำพระยานคร ทะเลบางปู และล่องเรือชมบึงบัวกลางเทือกเขาหินปูน เที่ยวครบในวันเดียว พร้อมรถรับ-ส่งถึงโรงแรมในหัวหิน',
    ],

    'facts' => [
        ['icon' => 'calendar', 'label' => ['en' => 'Duration', 'th' => 'ระยะเวลา'],
         'value' => ['en' => '1 day, 08:00 to 18:00', 'th' => '1 วัน (08:00 – 18:00 น.)']],
        ['icon' => 'pin', 'label' => ['en' => 'Stops', 'th' => 'จุดหมาย'],
         'value' => 'auto'], // auto = นับจากจำนวนสถานที่
        ['icon' => 'car', 'label' => ['en' => 'Pickup and return', 'th' => 'รับ-ส่ง'],
         'value' => ['en' => 'Your hotel in Hua Hin', 'th' => 'โรงแรมในหัวหิน']],
        ['icon' => 'mountain', 'label' => ['en' => 'Distance', 'th' => 'ระยะทาง'],
         'value' => ['en' => 'About 60 km from Hua Hin', 'th' => 'ประมาณ 60 กม. จากหัวหิน']],
    ],

    // สไลด์ใหญ่ด้านบน: accent = สีปุ่ม/เส้นของสไลด์นั้น
    'slides' => [
        [
            'title' => ['en' => 'Phraya Nakhon Cave', 'th' => 'ถ้ำพระยานคร'],
            'start' => '09:30', 'end' => '11:30',
            'desc'  => [
                'en' => 'Late morning sun falls through a gap in the cave roof and lights up the pavilion built for King Rama V.',
                'th' => 'แสงแดดลอดช่องเพดานถ้ำส่องลงมาที่พระที่นั่งคูหาคฤหาสน์ ภาพที่กลายเป็นสัญลักษณ์ของประจวบคีรีขันธ์',
            ],
            'image'  => 'unsplash:cIOxQvbLWfw',
            'accent' => '#D9A65B', 'bg_top' => '#C99B55', 'bg_bottom' => '#2C5A3B',
            'link'   => '#stop-phraya-nakhon',
        ],
        [
            'title' => ['en' => 'Sam Roi Yot Lotus Marsh', 'th' => 'ทุ่งสามร้อยยอด'],
            'start' => '14:00', 'end' => '16:00',
            'desc'  => [
                'en' => 'A local boat takes you through lotus and water lilies on the largest freshwater marsh in Thailand, with limestone cliffs all around.',
                'th' => 'ล่องเรือพื้นบ้านลัดเลาะดงบัวในบึงน้ำจืดกว้างสุดตา มีเทือกเขาหินปูนตั้งตระหง่านเป็นฉากหลัง',
            ],
            'image'  => 'unsplash:MpQkpyQ3sPE',
            'accent' => '#5FAE9C', 'bg_top' => '#3E8F88', 'bg_bottom' => '#1D4A73',
            'link'   => '#stop-wetland',
        ],
        [
            'title' => ['en' => 'Khao Sam Roi Yot', 'th' => 'เขาสามร้อยยอด'],
            'start' => '09:00', 'end' => '',
            'desc'  => [
                'en' => 'Thailand’s first marine national park. The name means three hundred peaks, and once you see the coastline you will understand why.',
                'th' => 'อุทยานแห่งชาติทางทะเลแห่งแรกของไทย ยอดเขาหินปูนนับร้อยเรียงรายริมอ่าวไทย',
            ],
            'image'  => 'unsplash:PRo0UDbanlA',
            'accent' => '#E8915A', 'bg_top' => '#C98F6B', 'bg_bottom' => '#2E3557',
            'link'   => '#program',
        ],
        [
            'title' => ['en' => 'Bang Pu Beach', 'th' => 'หาดบางปู'],
            'start' => '12:00', 'end' => '13:30',
            'desc'  => [
                'en' => 'A small fishing village and the trailhead for the cave. Lunch is fresh seafood a few steps from the boats.',
                'th' => 'หมู่บ้านชาวประมงริมทะเล จุดเริ่มทางขึ้นถ้ำพระยานคร และมื้อกลางวันอาหารทะเลสดริมหาด',
            ],
            'image'  => 'unsplash:uhz70XUMwSo',
            'accent' => '#4FA6CC', 'bg_top' => '#4E9BC0', 'bg_bottom' => '#1B3A5E',
            'link'   => '#stop-bang-pu',
        ],
        [
            'title' => 'Eureka Cafe',
            'subtitle' => ['en' => 'Coffee by the sea', 'th' => 'คาเฟ่ริมทะเล'],
            'start' => '16:30', 'end' => '17:30',
            'desc'  => [
                'en' => 'Iced coffee and something sweet by the water before the drive back to Hua Hin.',
                'th' => 'แวะพักจิบกาแฟเย็น ๆ กับของหวานในบรรยากาศริมทะเล ก่อนเดินทางกลับหัวหิน',
            ],
            'image'  => 'unsplash:NzBEU5fPp2U',
            'accent' => '#E2B04F', 'bg_top' => '#D49A78', 'bg_bottom' => '#2A496E',
            'link'   => '#stop-eureka',
        ],
    ],

    // โปรแกรมรายวัน (ถ้าเพิ่มวัน แถบเลือกวันจะขึ้นมาเอง)
    'days' => [
        [
            'title' => [
                'en' => 'Phraya Nakhon Cave, Bang Pu Beach and the lotus marsh',
                'th' => 'ถ้ำพระยานคร – ทะเลบางปู – ทุ่งสามร้อยยอด',
            ],
            'summary' => [
                'en' => 'We leave Hua Hin early so you reach the cave while the light is coming in. Lunch is by the sea, the afternoon is on the water, and we stop for coffee on the way back.',
                'th' => 'ออกจากหัวหินแต่เช้า ชมแสงลอดถ้ำช่วงสาย ทานมื้อกลางวันริมทะเล บ่ายล่องเรือชมบึงบัว แล้วแวะคาเฟ่ก่อนกลับโรงแรม',
            ],
            'start' => ['en' => 'Pickup from your Hua Hin hotel', 'th' => 'รับที่โรงแรมในหัวหิน'],
            'stops' => [
                [
                    'type' => 'note', 'time' => '08:00', 'icon' => 'car',
                    'text' => ['en' => 'Pickup from your hotel in Hua Hin', 'th' => 'บริการรับที่โรงแรมในหัวหิน'],
                ],
                [
                    'type' => 'note', 'time' => '09:00', 'icon' => 'pin',
                    'text' => ['en' => 'Arrive at Khao Sam Roi Yot National Park', 'th' => 'เดินทางถึงอุทยานแห่งชาติเขาสามร้อยยอด'],
                ],
                [
                    'id'    => 'phraya-nakhon',
                    'start' => '09:30', 'end' => '11:30',
                    'name'  => ['en' => 'Phraya Nakhon Cave', 'th' => 'สำรวจถ้ำพระยานคร'],
                    'desc'  => [
                        'en' => 'A large limestone cave where parts of the roof have fallen in, so sunlight and trees reach the floor. Inside stands Phra Thinang Khuha Kharuehat, a pavilion with four gables built in the reign of King Rama V. The initials of King Rama V and King Rama VII are carved into the cave wall.',
                        'th' => 'ถ้ำหินปูนขนาดใหญ่ที่เพดานบางส่วนยุบตัวเป็นช่องให้แสงส่องลงมา ภายในมีพระที่นั่งคูหาคฤหาสน์ ศาลาจัตุรมุขที่สร้างขึ้นในสมัยรัชกาลที่ 5 และมีพระปรมาภิไธยย่อของรัชกาลที่ 5 และรัชกาลที่ 7 จารึกไว้บนผนังถ้ำ',
                    ],
                    'image' => 'unsplash:gb8CqvwWsxk',
                    'tags'  => [
                        'en' => ['Hike', 'History', 'Photo spot'],
                        'th' => ['เดินขึ้นเขา', 'ประวัติศาสตร์', 'จุดถ่ายรูป'],
                    ],
                    'tip' => [
                        'en' => 'The trail up is about 430 metres and steep in places. Wear proper walking shoes and carry water. The light through the roof is best in the late morning.',
                        'th' => 'ทางเดินขึ้นถ้ำยาวราว 430 เมตร ค่อนข้างชัน ใส่รองเท้าผ้าใบและพกน้ำไปด้วย แสงลอดถ้ำจะสวยที่สุดช่วงสายก่อนเที่ยง',
                    ],
                    'transit' => ['en' => 'Walk back down to Bang Pu Beach', 'th' => 'เดินลงเขากลับมาที่หาดบางปู'],
                ],
                [
                    'id'    => 'bang-pu',
                    'start' => '12:00', 'end' => '13:30',
                    'name'  => ['en' => 'Lunch at Bang Pu Beach', 'th' => 'รับประทานอาหารกลางวันที่ชายหาดบางปู'],
                    'desc'  => [
                        'en' => 'Bang Pu is a small fishing village and the main starting point for the cave. Lunch is fresh seafood with the fishing boats and limestone hills in view.',
                        'th' => 'หมู่บ้านชาวประมงเล็ก ๆ ริมทะเล จุดเริ่มต้นหลักของการเดินทางไปถ้ำพระยานคร ทานอาหารทะเลสดพร้อมวิวเรือประมงและภูเขาหินปูน',
                    ],
                    'image' => 'unsplash:uhz70XUMwSo',
                    'tags'  => [
                        'en' => ['Seafood', 'Beach'],
                        'th' => ['อาหารทะเล', 'ริมหาด', 'พักผ่อน'],
                    ],
                    'tip' => [
                        'en' => 'Tell us about allergies or anything you don’t eat before the trip, and the restaurant will plan around it.',
                        'th' => 'แจ้งอาหารที่แพ้หรือไม่ทานล่วงหน้า ทางร้านจะได้เตรียมเมนูให้',
                    ],
                    'transit' => ['en' => 'Drive to the boat pier at Thung Sam Roi Yot', 'th' => 'นั่งรถไปท่าเรือทุ่งสามร้อยยอด'],
                ],
                [
                    'id'    => 'wetland',
                    'start' => '14:00', 'end' => '16:00',
                    'name'  => ['en' => 'Boat trip on Thung Sam Roi Yot', 'th' => 'ล่องเรือทุ่งสามร้อยยอด'],
                    'desc'  => [
                        'en' => 'This is the largest freshwater marsh in Thailand. A local boat moves slowly across still water, through lotus and water lilies, with limestone ridges behind. Watch for waterbirds on the way.',
                        'th' => 'พื้นที่ชุ่มน้ำจืดที่ใหญ่ที่สุดของประเทศไทย ล่องเรือพื้นบ้านไปตามผืนน้ำนิ่ง ผ่านดงบัวหลวงและบัวสาย มีเทือกเขาหินปูนเป็นฉากหลัง และมีนกน้ำให้ชมตลอดทาง',
                    ],
                    'image' => 'unsplash:JbZqJG_N0bQ',
                    'tags'  => [
                        'en' => ['Boat trip', 'Lotus marsh', 'Birdwatching'],
                        'th' => ['ล่องเรือ', 'บึงบัว', 'ดูนก'],
                    ],
                    'tip' => [
                        'en' => 'After the boat, walk out along the wooden boardwalk across the marsh. The afternoon sun is strong, so bring a hat and sunscreen.',
                        'th' => 'หลังล่องเรือ เดินชมสะพานไม้ทอดยาวกลางบึงต่อได้ แดดช่วงบ่ายค่อนข้างแรง เตรียมหมวกและครีมกันแดด',
                    ],
                    'transit' => ['en' => 'Drive to Eureka Cafe', 'th' => 'นั่งรถไป Eureka Cafe'],
                ],
                [
                    'id'    => 'eureka',
                    'start' => '16:30', 'end' => '17:30',
                    'name'  => 'Eureka Cafe',
                    'subname' => ['en' => 'Coffee and dessert', 'th' => 'กาแฟและของหวาน'],
                    'desc'  => [
                        'en' => 'A break after a full day out. Cold drinks and dessert, with the sea right in front of you.',
                        'th' => 'แวะพักผ่อนหลังเที่ยวมาทั้งวัน จิบเครื่องดื่มเย็น ๆ และของหวานในบรรยากาศสบาย ๆ ริมทะเล',
                    ],
                    'image' => 'unsplash:NzBEU5fPp2U',
                    'tags'  => [
                        'en' => ['Cafe', 'Dessert', 'Sea view'],
                        'th' => ['คาเฟ่', 'ของหวาน', 'วิวทะเล'],
                    ],
                    'tip' => [
                        'en' => 'The early evening light is good for photos by the water before you head back.',
                        'th' => 'ช่วงเย็นแสงสวย เหมาะกับการถ่ายรูปริมทะเลก่อนกลับ',
                    ],
                    'transit' => '',
                ],
                [
                    'type' => 'note', 'time' => '18:00', 'icon' => 'car',
                    'text' => [
                        'en' => 'We take you back to your hotel, or anywhere else you choose',
                        'th' => 'เดินทางไปส่งที่โรงแรม หรือตามความประสงค์ของผู้เดินทาง',
                    ],
                ],
            ],
        ],
    ],

    'contact' => [
        'title' => ['en' => 'Ready to go?', 'th' => 'พร้อมออกเดินทางหรือยัง?'],
        'text'  => [
            'en' => 'Ask us anything, book the trip, or change the plan to suit you.',
            'th' => 'สอบถามรายละเอียด จองทริป หรือปรับโปรแกรมให้เข้ากับคุณได้',
        ],
        'button_label' => ['en' => 'Contact us', 'th' => 'ติดต่อเรา'],
        'button_link'  => 'mailto:hello@example.com',
        'image' => 'unsplash:PRo0UDbanlA', // ภาพพื้นหลังส่วนติดต่อ
    ],

    // เครดิตรูปภาพ (Unsplash License) แก้ตามรูปที่ใช้จริง
    'credits' => ['Tomáš Malík', 'allPhoto Bangkok', 'Jim Thirion', 'Piya Kirdpanya'],
];
