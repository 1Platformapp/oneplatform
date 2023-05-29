<div class="footer_outer">
    <div class="footer_inner">
        <div class="footer_top">
            <section class="foot_each_side foot_side_left">
                <h3 class="foot_side_head">
                    Music Studio Near Me
                </h3>
                <p class="foot_side_para">
                    Our Recording studios have the equipment and staff needed to deliver an incredible experience. Our recording studios have worked with clients across the globe and produced a variety of famous tracks with various famous artists. This means no matter what you want from your experience we can suit your needs
                </p>
                <h3 class="foot_side_head">
                    Recording Studio Near Me
                </h3>
                <p class="foot_side_para">
                    Clients from all over the UK visit our studios in London, Dundee, Glasgow, NewCastle, Glastonbury, Dublin, Belfast, Leeds, Hull, Notingham, Peterborough, Colchester, Norwich, Oxford, Aberystwyth, Plymouth, Southampton, Hastings and Birmingham, Cardiff, Manchester, Liverpool, Devon, Cornwall and more
                </p>
            </section>
            <section class="foot_each_side foot_side_right">
                <div class="foot_side_group_links">
                    <h3 class="foot_side_head">
                        Categories
                    </h3>
                    <nav class="foot_link_contain">
                        <a href="{{route('singers.general')}}">
                            Singers
                        </a>
                        <a href="{{route('musicians.general')}}">
                            Musicians
                        </a>
                        <a href="{{route('bands.general')}}">
                            Bands
                        </a>
                        <a href="{{route('recording.general')}}">
                            Recording Studios
                        </a>
                        <a href="{{route('cover.shoots')}}">
                            Cover Shoots
                        </a>
                        <a href="{{route('parties.general')}}">
                            Parties
                        </a>
                        <a href="https://www.clients.singingexperience.co.uk">
                            Use Voucher
                        </a>
                    </nav>
                </div>
                @php $linkOne = \App\Models\UserProduct::find(179) @endphp
                @php $linkTwo = \App\Models\UserProduct::find(180) @endphp
                @php $linkThree = \App\Models\UserProduct::find(181) @endphp
                @php $linkFour = \App\Models\UserProduct::find(182) @endphp
                @php $linkFive = \App\Models\UserProduct::find(280) @endphp
                @php $linkSix = \App\Models\UserProduct::find(281) @endphp
                @php $linkSeven = \App\Models\UserProduct::find(188) @endphp
                <div class="foot_side_group_links">
                    <h3 class="foot_side_head">
                        Top Products
                    </h3>
                    <nav class="foot_link_contain">
                        <a title="{{$linkOne?$linkOne->title:''}}" href="{{$linkOne?route('item.share.product', ['itemSlug' => $linkOne->slug]):'#'}}">
                            Recording studio 1 singer, 1 song
                        </a>
                        <a title="{{$linkTwo?$linkTwo->title:''}}" href="{{$linkTwo?route('item.share.product', ['itemSlug' => $linkTwo->slug]):'#'}}">
                            Recording studio 1 singer, 3 songs
                        </a>
                        <a title="{{$linkThree?$linkThree->title:''}}" href="{{$linkThree?route('item.share.product', ['itemSlug' => $linkThree->slug]):'#'}}">
                            Recording studio 1 singer, 5 songs
                        </a>
                        <a title="{{$linkFour?$linkFour->title:''}}" href="{{$linkFour?route('item.share.product', ['itemSlug' => $linkFour->slug]):'#'}}">
                            Popstar party for 5, 1 song
                        </a>
                        <a title="{{$linkFive?$linkFive->title:''}}" href="{{$linkFive?route('item.share.product', ['itemSlug' => $linkFive->slug]):'#'}}">
                            Recording experience for singers & musicians
                        </a>
                        <a title="{{$linkSix?$linkSix->title:''}}" href="{{$linkSix?route('item.share.product', ['itemSlug' => $linkSix->slug]):'#'}}">
                            Recording experience for young singers
                        </a>
                        <a title="{{$linkSeven?$linkSeven->title:''}}" href="{{$linkSeven?route('item.share.product', ['itemSlug' => $linkSeven->slug]):'#'}}">
                            Band recording, 3 hours session
                        </a>
                    </nav>
                </div>
            </section>
        </div>
    </div>
    <div class="footer_separator"></div>
    <div class="footer_inner footer_ending">
        <div class="footer_bottom">
            <div class="foot_bottom_each_sec">
                <img alt="Singing Experience - A Professional Recording Studio in UK" class="foot_logo" src="{{asset('images/se_logo.jpg')}}">
            </div>
            <div class="foot_bottom_each_sec">
                <a href="">Terms</a>
            </div>
            <div class="foot_bottom_each_sec">
                <a href="{{route('se.faq')}}">FAQ</a>
            </div>
            <div class="foot_bottom_each_sec">
                <a href="">Privacy</a>
            </div>
            <div class="foot_bottom_each_sec">
                Copyright 2008 - 2021 | singingexperience.co.uk | All Rights Reserved
            </div>
            <div class="foot_bottom_each_sec">
                <div class="foot_social_contain">
                    <div class="foot_social_each">
                        <a href="https://www.facebook.com">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                    <div class="foot_social_each">
                        <a href="https://www.facebook.com">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                    <div class="foot_social_each">
                        <a href="https://www.facebook.com">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                    <div class="foot_social_each">
                        <a href="https://www.facebook.com">
                            <i class="fab fa fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>