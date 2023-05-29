<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style>
            table { width: 100% !important; }
        </style>
    </head>
    <body style="width:1000px;" >
        @php $licenses = config('constants.licenses'); @endphp
        <table align="center" style="width:100%;" cellpadding="0" cellspacing="0" >
            <tr>
                <td style="width:100%;vertical-align:top;">
                    <table align="center" style="width:100%; padding-left: 12px; padding-right: 17px;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td style="height: 8px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 24px; width:100%;vertical-align:bottom;text-align:center;">
                            @if($license == 'bespoke')
                                BESPOKE LICENSE
                            @else
                                {{strtoupper($licenses[$license]['filename'])}}
                            @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="height: 30px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">LICENSE GRANTED BY</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{$sellerDetails['name']}}
                                @if($sellerDetails['address'] != '')
                                <br>
                                {{$sellerDetails['address']}}
                                @endif
                                @if($sellerDetails['city'] != '' && $sellerDetails['country'] != '')
                                <br>
                                {{$sellerDetails['city'].' - '.$sellerDetails['country']}}
                                @endif
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">LICENSE GRANTED TO</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{$buyerDetails['name']}}
                                @if($buyerDetails['address'] != '')
                                <br>
                                {{$buyerDetails['address']}}
                                @endif
                                @if($buyerDetails['city'] != '' && $buyerDetails['country'] != '')
                                <br>
                                {{$buyerDetails['city'].' - '.$buyerDetails['country']}}
                                @endif
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">DATE OF LICENSE</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{date('d/m/Y')}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">LICENSE ITEM AND PRICE</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{$music->song_name}}<br>
                                {{number_format($price, 2).' '.strtoupper($sellerDetails['defaultCurrency'])}}
                            </td>   
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">LICENSE END TERM</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{$endTermSelect == 'perpetual' ? 'Perpetual' : $endTerm}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        @if($terms != '')
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">ADDITIONAL TERMS</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;">
                                {{$terms}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        @endif
                    </table>
                    <table align="center" style="width:100%; padding-left: 12px; padding-right: 17px;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">NOW IT IS HEREBY AGREED AS FOLLOWS</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">1. DEFINITIONS</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">In this Licence</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                “Territory” shall mean: Worldwide
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                “Term” shall mean: {{$endTermSelect == 'perpetual' ? 'Perpetual' : $endTerm}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                “Fee” shall mean: {{number_format($price, 2).' '.strtoupper($sellerDetails['defaultCurrency'])}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                “Media” shall mean: All digital and non digital mediums necessary for the {{ucfirst($license)}}
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">2. LICENCE</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                2.1 In consideration of your payment to us of the Fee we hereby license to you for the
                                Territory during the Term the non-exclusive right to record, duplicate and release the Work
                                as part of the {{ucfirst($license)}} in whatever medium(s) necessary, to use the music as a
                                soundtrack "synced" with visual images as part of the {{ucfirst($license)}}; and to use the music as
                                part of the public viewing or broadcast of the {{ucfirst($license)}} throughout the Territory solely for
                                distribution in the Media subject always to the terms and conditions contained herein.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">3. TERMS AND CONDITIONS</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                3.1 This licence becomes valid from the purchase date listed above.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                3.2 This licence does not include the right to sample and/or change the lyrics, the music
                                and/or the character of the music of the Composition unless agreed in the additional terms box above, that being a bespoke or remix license.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                3.3 Any use of the Composition not expressly authorised hereunder shall constitute an
                                infringement of the copyrights in the Composition.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                3.4 Performance or broadcast of the Composition in the exhibition of the {{ucfirst($license)}} is
                                subject to the rules of the relevant performing rights societies and the payment of their
                                customary fees and royalties by you.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                3.5 You shall furnish us free of charge a copy of the {{ucfirst($license)}} on any format as
                                requested by us.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                    </table>
                    <table align="center" style="width:100%; padding-left: 12px; padding-right: 17px;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                3.6 You hereby agree to accord credit to us wherever other material credits are given in
                                relation to the {{ucfirst($license)}} in no less favourable position in the following form “Produced
                                by:
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">4. WARRANTIES AND REPRESENTATIONS</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                4.1 We hereby represent and warrant that we have full right, power and authority to enter
                                into this Licence and to grant to you the rights herein set out upon the terms and conditions
                                herein contained and in the event of any breach of this or any other warranty (express or
                                implied) by us then in no event shall our total liability exceed the Fee paid by us hereunder.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                4.2 You hereby represent and warrant that you have full right, power and authority to enter
                                into this Licence.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">5. TERMINATION</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                5.1 In the event that you or your assignees or sub-licensees are in breach of any of the
                                terms of this Licence and in the case of breaches that can be remedied such breach is not
                                remedied within 15 (fifteen) days of written notice to remedy from us, then this Licence shall
                                terminate and we shall be entitled to retain all monies theretofore paid to us without
                                prejudice to any of our other rights or remedies.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                5.2 We shall have the right to terminate this Licence and your rights in the Composition
                                hereunder if you shall enter into liquidation (other than a voluntary liquidation for the
                                purposes of reconstruction or reorganisation) or if it makes any Composition with its
                                creditors or if a Trustee or a Receiver is appointed to take over all or a substantial part of
                                your assets and undertakings and is in control thereof for 15 (fifteen) days or more.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                5.3 Upon the expiration of the Term or other termination of this Licence all rights herein
                                granted shall immediately terminate and no further exploitation of the Composition by you
                                shall be permitted hereunder.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                    </table>
                    <table align="center" style="width:100%; padding-left: 12px; padding-right: 17px;" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 17px;  width:100%;vertical-align:bottom;">6. NON-ASSIGNMENT</td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                6.1 You may not assign or sub-license any of the rights granted hereunder to any third party
                                without our prior written approval. No such transfer or assignment shall become effective
                                unless and until the transferee or assignee shall deliver to us a written agreement assuming
                                the further performance of your obligations hereunder, and no such transfer or assignment
                                shall relieve you of any obligation hereunder.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                6.2 However, you may enter into sub-licences within the Territory to the extent necessary to
                                permit the exhibition of the {{ucfirst($license)}} in accordance with this Licence.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                6.3 This Licence shall be governed by and construed in accordance with English Law and
                                the parties hereby submit to the exclusive jurisdiction of the Courts of England and Wales.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                6.4 This Licence contains all of the terms agreed between the parties and replaces any and
                                all previous agreements, whether written or oral, concerning the subject matter hereof. This
                                Licence shall not be modified or varied except by a written instrument signed by the parties.
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="height: 15px;width:55%;vertical-align:top;"></td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color:#444;line-height:25px;width:100%;vertical-align:bottom;">
                                6.5 All notices hereunder required to be given to you shall be sent to you at the address
                                mentioned herein. All notices and/or payments required to be made to us shall be sent to us
                                at our current address specified above or to such other address as we may hereinafter
                                designate by notice in writing to you
                            </td>
                            <td style="width:30%;vertical-align:top;"></td>
                            <td style="width:15%;vertical-align:top;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>