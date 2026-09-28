@extends('front.app')

@section('title', 'Pratham Filter Industries | contact')

@section('content')


<section class="page_hero" style="background-image: url('{{ asset('front/img/figma/about/page-hero-bg.jpg') }}');">
    <div class="page_hero_overlay"></div>
    <div class="container position-relative">
        <div class="page_hero_content">
            <div class="breadcrumb_row">
                <a href="{{ url('/') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Contact us</span>
            </div>
            <h1 class="page_hero_title">Contact Us</h1>
        </div>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <h2 class="title mb-3">Get in touch with us</h2>
        <p class="sub_text_p16 mb-5">Please complete the form below. If you have any questions, feel free to get in touch with us.</p>

        <div class="contact_grid">
            <span class="vmp_border_line vmp_border_top"></span>
            <span class="vmp_border_line vmp_border_bottom"></span>
            <span class="vmp_border_side vmp_border_left"></span>
            <span class="vmp_border_side vmp_border_right"></span>
            <span class="contact_grid_divider"></span>

            <form class="contact_form">
                <div class="contact_field"><input type="text" placeholder="Name" required></div>
                <div class="contact_field"><input type="email" placeholder="Email ID" required></div>
                <div class="contact_field"><input type="tel" placeholder="Phone Number"></div>
                <div class="contact_field"><textarea placeholder="Message" rows="4"></textarea></div>
                <div class="contact_field border-0"><button class="purple-btn" type="submit">Contact us</button></div>
            </form>

            <div class="contact_info">
                <div class="contact_info_block">
                    <div class="contact_info_label">
                        <img src="{{ asset('front/img/figma/contact/icon-headquarters.svg') }}" alt=""><span>Headquarters</span>
                    </div>
                    <p class="contact_info_value">K 12 A, Ansa Indl Estate, Saki Vihar Road, Andheri (E), Mumbai-400072.</p>
                </div>
                <div class="contact_info_row">
                    <div class="contact_info_block">
                        <div class="contact_info_label">
                            <img src="{{ asset('front/img/figma/contact/icon-branch-phone.svg') }}" alt=""><span>Contact Us</span>
                        </div>
                        <p class="contact_info_value"><a href="tel:+919820246044">+91 98 202 46044</a></p>
                    </div>
                    <div class="contact_info_block">
                        <div class="contact_info_label">
                            <img src="{{ asset('front/img/figma/contact/icon-email.svg') }}" alt=""><span>Email Us</span>
                        </div>
                        <p class="contact_info_value"><a href="mailto:ajay@prathamfilter.com">ajay@prathamfilter.com</a></p>
                    </div>
                </div>
                <div class="contact_info_block">
                    <div class="contact_info_label">
                        <img src="{{ asset('front/img/figma/contact/icon-office-lines.svg') }}" alt=""><span>Office Lines</span>
                    </div>
                    <p class="contact_info_value">+91 22 352 31803 &nbsp;|&nbsp; +91 22 356 16243</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29386.132594725917!2d72.45635881083984!3d22.977222899999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e9a95007cb573%3A0xc4b5bda7e22253c!2spratham%20filter%20industries!5e0!3m2!1sen!2sin!4v1790145958860!5m2!1sen!2sin" width="100%" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>
</section>

<section class="section_padding">
    <div class="container">
        <h2 class="title mb-5 text-center">Locate us</h2>
        <div class="branch_grid">
            <?php
            $branches = [
                ["AHMEDABAD", "19, Singal estate, Behind Jaipur Golden Transport, SG Highway, Sarkhej, Ahmedabad-380022", "+91 75 739 98044", "ahmedabad@prathamfilter.com"],
                ["DELHI", "B- 48, Indra Enclave, Near IGNOU Road, Neb Sarai, New Delhi-110068", "+91 88 008 98044", "delhi@prathamfilter.com"],
                ["CHENNAI", "1/61, Neelakantha Mudaliar Street, Vanagaram, Chennai - 600095", "+91 93 803 98044", "chennai@prathamfilter.com"],
                ["KOLKATA", "218, Diamond Arcade, 1/72 Jessore Road, Shyam Nagar, Kolkata- 700055", "+91 93 305 98044", "kolkata@prathamfilter.com"],
                ["GUWAHATI", "House No. 14, Road No. 78, RGB Bye Lane, LKB Road, Nabin Nagar, Guwahati - 781024.", "+91 97 062 98044", "guwahati@prathamfilter.com"],
                ["PUNE", "C 13, Green Park Society, Opp. Dr. Beck & Co., Kamgar Nagar, Pimpri, Pune - 411018", "+91 73 046 68044", "pune@prathamfilter.com"],
                ["HYDERABAD", "B- 4, IDA UPPAL, Unit No.6, Hyderabad - 500039", "+91 75 739 98044", "ahmedabad@prathamfilter.com"],
                ["BHIWANDI", "Bldg. No. C, Unit No. 15 & 16, Bhagwan Seth Estate, Bhd. Anrahit Compound, Purna Village, Bhiwandi - 421302", "+91 93 202 98044", "bhiwandi@prathamfilter.com"],
            ];
            
            foreach ($branches as $b): ?>
            <div class="branch_card">
                <span class="vmp_border_line vmp_border_top"></span>
                <span class="vmp_border_line vmp_border_bottom"></span>
                <span class="vmp_border_side vmp_border_left"></span>
                <span class="vmp_border_side vmp_border_right"></span>
                <img src="{{ asset('front/img/figma/contact/branch-photo.jpg') }}" alt="<?php echo $b[0]; ?> office" class="w-100 branch_card_img">
                <div class="branch_card_body">
                    <h3 class="branch_card_title"><?php echo $b[0]; ?></h3>
                    <p class="branch_card_address"><?php echo $b[1]; ?></p>
                    <p class="branch_card_phone"><img src="{{ asset('front/img/figma/contact/icon-branch-phone.svg') }}" alt=""> <?php echo $b[2]; ?></p>
                    <p class="branch_card_email"><img src="{{ asset('front/img/figma/contact/icon-email.svg') }}" alt=""> <?php echo $b[3]; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


@endsection
