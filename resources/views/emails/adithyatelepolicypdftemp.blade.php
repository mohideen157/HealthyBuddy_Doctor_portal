<!DOCTYPE html>
<html>

    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    


<body style="font-family: Times New Roman;  margin: 20px;">
      <header style="width:100%;">
        <img src="assets/img/logo.png" style="width: 95%;height: 100px; margin: 20px;">
         
     </header>
 <div style="margin: 20px;">
        <label style="color: rgb(214,80,38); margin: 10px;"> Group Activ Secure - Certificate of Insurance<br></label>
   
     
  <table class="table table-bordered">
  
    <tbody>
      <tr>
                    <td>Policy Issuing Office</td>
                    <td>Aditya Birla Health<br>Insurance Company Limited, 10th Floor, R-Tech Park, Nirlon Compound, Goregaon-East, Mumbai - 400063</td>
                    <td>Policy Servicing Office</td>
                    <td>Aditya Birla Health Insurance Company Limited, 7th floor, C building, Modi Business Centre, Kasarvadavali, Mumbai, Thane West -400615</td>
                </tr>
                <tr>
                    <td>Master Policy Number</td>
                    <td>62-20-00035-00-00</td>
                    <td>Certificate Number</td>
                    <td>{{$users->application_no}}</td>
                </tr>
                <tr>
                    <td>Product<br> Name<br></td>
                    <td>Group Active Secure<br></td>
                    <td>Member Id<br></td>
                    <td>{{$users->memeber_id}}<br></td>
                </tr>
                <tr>
                    <td>Plan Name<br></td>
                    <td>Group Active Secure - Personal Accident<br></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Name of Insured Person Residential Address of Insured<br>Person<br></td>
                    <td>{{$insuredname[0]}}<br>
                        {{$billingaddress1[0]}}<br>
                        {{$billingcity1[0]}}<br>
                        {{$billingstate1[0]}}<br>
                        {{$billingcountry1[0]}}<br>
                        {{$billingpostcode1[0]}}
                    </td>
                    <td>Unique Identification Number</td>
                    <td>{{$users->memeber_id}}</td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>{{$insuredsex[0]}}</td>
                    <td>Date of Birth</td>
                    <td>{{$insureddob[0]}}</td>
                </tr> 
                <tr>
                    <td>Mobile number</td>
                    <td>{{$billingphone1[0]}}</td>
                    <td>Email ID</td>
                    <td>{{$billingemail1[0]}}</td>
                </tr>
                  </tbody>
  </table>


<table class="table table-bordered">
  
    <tbody>
    
                    <tr>
                    <td>Inception date &amp; Time of Master Policy</td>
                    <td>26-05-2020 00:00 hrs</td>
                </tr>
                <tr>
                    <td>Expiry Date &amp; Time of Master Policy</td>
                    <td>25-05-2021 23:59 on</td>
                </tr>
                <tr>
                    <td>Period of Insurance</td>
                    <td>1 Year</td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td>{{$dt1}}</td>
                </tr>
                <tr>
                    <td>End Date</td>
                    <td>{{$dt2}}</td>
                </tr>
 
                  </tbody>
  </table>

</div>
<div style="margin:20px;">


<table class="table table-bordered">
    
    <tbody>
       <tr>
        <td style="color: rgb(255,255,255);background-color: #f87b5f;"><strong>Insured Detail</strong><br></td>
         </tr>
      </tbody>
  </table>


<table class="table table-bordered">
    
    <tbody>
       <tr>
                    <td><strong>Insured Person</strong><br></td>
                    <td><strong>Date of Birth</strong><br></td>
                    <td><strong>Gender</strong><br></td>
                    <td><strong>Nominee</strong><br></td>
                    <td><strong>Relationship</strong><br></td>
                    <td><strong>Sum Insured</strong><br></td>
                </tr>
                <tr>
                    <td>{{$insuredname[0]}}</td>
                    <td>{{$insureddob[0]}}</td>
                    <td>{{$insuredsex[0]}}</td>
                    <td>{{$insuredpersonnominee1[0]}}</td>
                    <td>{{$insuredpersonrelationship1[0]}}</td>
                    <td>As per coverage details<br></td>
                </tr>
      </tbody>
  </table>



    </div>
    <div style="margin:20px;">
        <table class="table table-bordered">
           <tbody>
               <tr>
                   <td style="color: rgb(255,255,255);background-color: #f87b5f;"><strong>Coverage Details</strong><br></td>
               </tr>
           </tbody>
       </table>
       </div>
<div style="margin:20px;">
         <table class="table table-bordered">
         <thead>
                <tr>
                    <th><strong>Group Active Secure - Personal Accident</strong><br></th>
                    <th><strong>INR 5,000</strong><br></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Section A: Basic Covers</strong><br></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Accidental Death<br></td>
                    <td>INR 5,000<br></td>
                </tr>
                <tr>
                    <td><strong>Special Condition</strong><br></td>
                    <td><br></td>
                </tr>
                <tr>
                    <td>Unlimited Doc on call<br></td>
                    <td><br></td>
                </tr>
            </tbody>
        </table>




    </div>


     <div style="margin:20px;">
         <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="color: rgb(255,255,255);background-color: #f87b5f;"><strong>Greviance Redressal</strong><br></td>
                </tr>
            </tbody>
        </table>
        </div>

<div style="margin:20px;">
<p style="margin-right: 20px;margin-left: 20px;text-align: justify;">In case of a grievance, you can contact Us with the<br>details
        through: Our website: adityabirlacapital.com/health insurance<br>Email:<a href="mailto:care.healthinsurance@adityabirlacapital.com">care.healthinsurance@adityabirlacapital.com</a> <br>Toll Free: 1800 270 7000<br>Address: Any of Our Branch office or Corporate office For senior citizens, please contact the respective branch office of the Company or call at 1800 270 7000 or may write an e- mail at <a href="mailto:seniorcitizen.healthinsurance@adityabirlacapital.com">seniorcitizen.healthinsurance@adityabirlacapital.com</a>.You can also walk-in and approach the grievance cell at any of Our branches. If in case You are not satisfied with the response then You can contact Our Head of Customer Service at the following email <a href="mailto:carehead.healthinsurance@adityabirlacapital.com">carehead.healthinsurance@adityabirlacapital.com</a>.If You are still not satisfied with Our redressal, You may approach the nearest Insurance Ombudsman. The Contact details of the Ombudsman offices are provided on Our Website and in the policy.</p>



    </div>


     <div style="margin:20px;">

        <table class="table table-bordered">
          <thead>
          <tr>
                 <th colspan="2" class="text-center"><strong>Policy Exclusions</strong></th>
                 </tr>
            </thead>
            <tbody>
                <tr>
                   
                    <td>Group Personal Accident<br></td>
                    <td>As per Annexure 1<br></td>
                
                
                </tr>
            </tbody>
        </table>



    </div>

    <div style="margin:20px;">
    <table class="table table-bordered">
    <thead>
                <tr>
                <td style="color: rgb(255,255,255);background-color: #f87b5f;"><strong>Premium Details</strong></td>
                </tr>
            </thead>
            <tbody>
                <tr></tr>
            </tbody>
        </table>
        </div>



        <div style="margin:20px;">
        <table class="table table-bordered">
    <thead>
                <tr>
                    <th><strong>Particulars</strong><br></th>
                    <th><strong>Amount (Rs.)</strong><br></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Net Premium<br></td>
                    <td>{{$product_net_revenue[0]/$item_qty}}</td>
                </tr>
                <tr>
                    <td>CGST (9%)<br></td>
                    <td>{{$CGST}}</td>
                </tr>
                <tr>
                    <td>SGST / UTGST (9%)<br></td>
                    <td>{{$SGST}}</td>
                </tr>
                <tr>
                    <td>IGST (18%)<br></td>
                    <td>{{$IGST}}</td>
                </tr>
                <tr>
                    <td>Total Premium<br></td>
                    <td>{{$product_gross_revenue[0]/$item_qty}}</td>
                </tr>
                <tr>
                    <td>Premium payment mode<br></td>
                    <td>Yearly</td>
                </tr>
            </tbody>    
            </table>
    
    </div>

    <div style="margin: 20px;">
     <p class="text-center d-block">GST Registration No.: 27AANCA4062G1ZN&nbsp; &nbsp; &nbsp;Category: General Insurance&nbsp; &nbsp; SAC Code: 997133</p>

     </div>

     <div style="margin:20px;">


     <table class="table table-bordered">
    
      <tbody>
       <tr>
        <td colspan="3" style="color: rgb(255,255,255);background-color: #f87b5f;"><b>Claim Process</b></td>
         </tr>
      </tbody>
     </table>
    </div>
    
     <div style="margin-top: 20px;">

             <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td rowspan="3">Please contact us through any of these Modes</td>
                        <td>Address for Correspondence</td>
                        <td>Aditya Birla Health Insurance Company Limited, 5th floor, C building, Modi Business Centre, Kasarvadavali, Mumbai, Thane West -400615</td>
                    </tr>
                    <tr>
                        <td>Contact Number<br></td>
                        <td>1800 270 7000<br></td>
                    </tr>
                    <tr>
                        <td>Email ID<br></td>
                        <td>care.healthinsurance@adityabirlacapital.com<br></td>
                    </tr>
                   </tbody>
                </table>

     </div>

<div>
  <p class="text-justify" style="margin: 20px;">
        <strong>Stamp Duty:</strong> The stamp duty of INR 1/- paid vide MH011444489201920M dated 01/02/2020, received from Stamp Duty Authorities vide Receipt No./GRASS DEFACE NO 0006038796201920 dated 05/02/2020, payment has been made vide Letter of Authorisation No. CSD/315/2020/862/2020 dated 27/02/2020 from Main Stamp Duty Office.
    </p>
 </div>


<div style="margin:20px;">
       
                    <div> 
                    <label>
                    <strong>Master Policy Number:<p>62-20-00035-00-00</p></strong></label>
                     <label style="float: right;"><strong>Certificate Number:<p>{{$users->application_no}}</p></strong></label><br>
                    </div>
                    <div style="margin-top: 50px;">
                    <label ><strong>Date</strong>:</label>
                    <label style="float: right;"><strong>Place</strong>: <strong>Mumbai</strong><br></label>
                    </div>
               
    </div>

    <div style="margin:20px;text-align: justify;">
        <p style="margin-top: 20px;"><strong>Note: </strong>Amount is inclusive of all taxes and cesses as applicable. This certificate must be surrendered to the Insurance Company for issuance of fresh certificate in case of cancellation of Master Policy or any alteration in the insurance affecting the premium.</p>
    </div>

    <div style="margin:20px;text-align: justify;">
        <p style="margin-top:20px; "><strong>Important ???</strong><br></p>
        <p style="margin-top: 20px;margin: 20px;"><strong>1)</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; In case of payment by cheque, in the event of dishonour of cheque for any reason whatsoever, insurance provided under this document automatically stands cancelled from the inception irrespective of whether a separate communication is sent or not.</p>
    </div>


    <div style="text-align: justify; margin:20px;">
        <table class="table table-bordered">
    
            <tbody>
                <tr>
                    <td style="width: 50%;height: 100%;font-size:11px;">
                        We shall not be liable to make any payment for any claim under any Benefit under Section II.A. or Section II.B., in respect of any Insured Person, directly or indirectly for, caused by or arising from or in any way attributable to any of the following: <br>
1. Any Pre-Existing Disease or Injury or disability arising out of a Pre-Existing Diseases or any complication arising therefrom.<br> 
2. Any payment in case of more than one claim under the Policy during any one Policy Period by which Our maximum liability in that period would exceed the Sum Insured. This would not apply to payments made under the Additional Covers. <br>
3. Suicide or attempted suicide, intentional self-inflicted Injury, acts of self-destruction whether the Insured Person is medically sane or insane.<br> 
4. Mental Illness or sickness or disease including a psychiatric condition, mental disorders of or disturbances of consciousness, strokes, fits or convulsions which affect the entire body and pathological disturbances caused by mental reaction to the same.<br> 
5. Certification by a Medical Practitioner who shares the same residence as the Insured Person or who is a member of the Insured Person???s family. <br>
6. Death or disablement arising out of or attributable to foreign invasion, act of foreign enemies, hostilities, warlike operations (whether war be declared or not or while performing duties in the armed forces of any country during war or at peace time), participation in any naval, military or air-force operation, civil war, public defence, rebellion, revolution, insurrection, military or usurped power. <br>
7. Death or disablement directly or indirectly caused by or associated with any venereal disease or sexually transmitted disease. <br>
8. Congenital internal or external diseases, defects or anomalies or in consequence thereof.<br> 
9. Bacterial infections (except pyogenic infection which occurs through a cut or wound due to Accident). <br>
10. Medical or surgical treatment except as necessary solely and directly as a result of an Accident. <br>
11. Death or disablement directly or indirectly caused due to or associated with human T-call Lymph tropic virus type III (HTLV-III or IITLB-III) or Lymphadinopathy Associated Virus (LAV) and its variants or mutants, Acquired Immune Deficiency Syndrome (AIDS) whether or not arising out of HIV, AIDS related complex syndrome (ARCS) and any injury caused by and/or related to HIV.<br> 
12. Any change of profession after inception of the Policy which results in the enhancement of Our risk under the Policy, if not accepted and endorsed by Us on the Policy Schedule or Certificate of Insurance. <br>
13. Death or disablement arising or resulting from the Insured Person committing any breach of law or participating in an actual or attempted felony, riot, crime, misdemeanour or civil commotion with criminal intent. <br>
14. Death or disablement arising from or caused due to use, abuse or a consequence or influence of an abuse of any substance, intoxicant, drug, alcohol or hallucinogen.<br>
15. Death or disablement resulting directly or indirectly, contributed or aggravated or prolonged by childbirth or from pregnancy or a consequence thereof including ectopic pregnancy unless specifically arising due to Accident;

                    </td>
                    <td style="width: 50%;height:100%;font-size:11px;">
                        16. Death or disablement caused by participation of the Insured Person in any flying activity, except as a bona fide, fare-paying passenger of a recognized airline on regular routes and on a scheduled timetable.<br>
17. Insured Persons whilst engaging in a speed contest or racing of any kind (other than on foot), bungee jumping, parasailing, ballooning, parachuting, skydiving, paragliding, hang gliding, mountain or rock climbing necessitating the use of guides or ropes, potholing, abseiling, deep sea diving using hard helmet and breathing apparatus, polo, snow and ice sports in so far as they involve the training for or participation in competitions or professional sports and specified in the Policy Schedule.<br>
18. Insured Persons involved in naval, military or air force operations.<br>
19. Working in underground mines, tunnelling or explosives, or involving electrical installation with high tension supply, or as jockeys or circus personnel, or engaged in Hazardous Activities.<br>
20. Accidental death or Injury occurring after twelve calendar months from the date of the Accident.<br>
21. Death or disablement unless directly caused by an Accident.<br>
22. Death or disablement or Injury arising from or caused by ionizing radiation or contamination by radioactivity from any nuclear fuel (explosive or hazardous form) or resulting from or from any other cause or event contributing concurrently or in any other sequence to the loss, claim or expense from any nuclear waste from the combustion of nuclear fuel, nuclear, chemical or biological attack.<br>
a) Chemical attack or weapons means the emission, discharge, dispersal, release or escape of any solid, liquid or gaseous chemical compound which, when suitably distributed, is capable of causing any Illness, incapacitating disablement or death.<br>
b) Biological attack or weapons means the emission, discharge, dispersal, release or escape of any pathogenic (disease producing) microorganisms and/or biologically produced toxins (including genetically modified organisms and chemically synthesized toxins) which are capable of causing any Illness, incapacitating disablement or death.<br>
23. Any physical, medical or mental condition or treatment or service that is specifically excluded in the Policy.<br>
24. Any Injury which shall result in Hernia.<br>
25. Any Benefit under the policy arising from Hernia.<br><br>


For detailed policy wordings regarding the above please visit our website https://www.adityabirlahealth.com/healthinsurance/#!/downloads

                    </td>
                </tr>
            </tbody>
             </table>

    </div>

<div style="margin: 20px;  text-align: justify;">
        <p style="margin-top: 20px;margin-left: 20px;"><strong>ANNEXURE 1 ??? PERMANENT EXCLUSIONS&nbsp;</strong><br></p>
            <p style="margin-left: 20px;">*This is a computer generated document and does not need a signature<br></p>
    </div>


    <div style="margin: 20px;display: inline-block;">

                      
                       <p  style="font-size: 10px;width:200px;float: left;">Aditya Birla Health Insurance Co. Limited. IRDAI Reg.153. CIN No. >U66000MH2015PLC263677. <br>Product Name: Group Activ Secure, Product UIN: IRDAI/HLT/ABHI/P-H(G)/V.1/18/2016-17 <br>Address:- 10th Floor, R-Tech Park, Nirlon Compound, Next to HUB Mall, Off Western Express Highway, <br>Goregaon East, Mumbai ??? 400 063. Fax: +91 22 6225 7700 Email: <a href="mailto:care.healthinsurance@adityabirlacapital.com">care.healthinsurance@adityabirlacapital.com</a><br>Website: adityabirlahealthinsurance.com Trademark/Logo Aditya Birla Capital logo is owned by Aditya Birla Management Corporation Private Limited and is used by Aditya Birla Health Insurance Co. Limited under licensed user agreement(s).</p>
                        
                        
                        
                        <img src="assets/img/team&condition1.png" style="width:200px;float: right;">
                        </img>
               
        </div>        
  
          
       <div style="margin-top:400px;text-align: justify;> 
        <p style="margin:20px; class="text-center" >
            <b>OPD Benefit - Tele Consultation</b></p>
            </div>
       <div style="margin:20px;text-align: justify;>
             <p>
                1. COI to have whitelabled link to book appointments <a href="https://www.healthassure.in/Products/adityabirla">https://www.healthassure.in/Products/adityabirla</a><br>
                2. Once COI generated information linked to partner portal<br>
                3. User logs in to the partner portal <br>
                4. An auto-generated emailer is sent to user, with login credentials (username and password) via the email id&nbsp;support
                @healthassure.in along with the website link/app details in the mail.<br>
                5. User uses the user id and password sent on emailer and SMS.<br>
                6. The user would get to see credit on the Tele Consultation tab.<br>
                7. Click on Consultation tab. Click on the Package assigned to you and select ???BOOK APPOINTMENT???.<br>
                8. Fill in details required for booking appointment.<br>
                9. Click on Request Appointment, post filling alldetails.<br>
                10. User receives an appointment request confirmation tab, and an appointment request acknowledgement SMS and email immediately,
                acknowledging the receipt of the appointment request. <br>
                11. Within 2 hours the user gets an call from Tele Consultation doctor appointment confirmation email and SMS on the same day as placing the request, except on Sundays. The request cut-off time is 5 pm on weekdays and Saturday<br>
                12. Services available Monday to Saturday 8:00 Am to 8:00 Pm.<br>
                13. Appointments can be cancelled and re schedule from the portal itself.<br>
                </p>
            
        </div>

        <div style="margin: 20px;  text-align: justify;">
            <p
                class="text-center" style="font-size: 20px;"><strong><span style="text-decoration: underline;">VAS - Mode of utilization</span></strong></p>
                <p class="d-inline-block"style="margin: 20px;"><strong>Partner Stores</strong><br></p>
                <p style="margin: 50px;">Step - 1 Visit our network wellness partner center<br>Step - 2 Confirm the discount on service for the particular partner from the app before your visit<br>Step - 3 Show your Wellness Saver Card for availing applicable benefit <br>Step- 4 Write to us at <a href="mailto:abhicl.vas@adityabirlacapital.com">abhicl.vas@adityabirlacapital.com</a><br></p>
                <p class="d-inline-block" style="margin:20px;"><strong>Online Partners</strong><br></p>
                <p style="margin: 50px;">Step - 1 Visit our wellness partner???s website<br>Step - 2 Enter the discount coupon code as mentioned in the app at checkout<br>Step - 3 Select the desired service that is applicable for the discount<br>Step - 4 Applicable discount will be applied &amp; proceed for payment.</p>

                <div>
                <center>
                <img class="d-md-flex" src="assets/img/wellnesssavercard.png" style="width: 300px;height: 200px;">
                </center>
                </div>
            
        </div>

        
<div style="margin: 20px;">
    <table style="margin-top: 40px;"class="table table-bordered">
      <thead>
              <tr>
                  <th>Partner Category</th>
                  <th>Partners</th>
                  <th>Total Centres</th>
                  <th>Affinity discount</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>Consultation</td>
                  <td>Cloud Nine Hospital</td>
                  <td>9</td>
                  <td>Up to 10% on various services</td>
              </tr>
              <tr>
                  <td>Consultation</td>
                  <td>Express Clinics</td>
                  <td>21</td>
                  <td>Up to 20% discount on various services</td>
              </tr><tr>
                  <td>Consultation</td>
                  <td>Family Doctor</td>
                  <td>27</td>
                  <td>Up to 15% discount on various services</td>
              </tr><tr>
                  <td>Consultation</td>
                  <td>Healthcare @ Home</td>
                  <td>2</td>
                  <td>Up to 30% discount on various services</td>
              </tr><tr>
                  <td>Consultation</td>
                  <td>Medall</td>
                  <td>15</td>
                  <td>Flat 10% discount on various services</td>
              </tr><tr>
                  <td>Consultation</td>
                  <td>Qi spine</td>
                  <td>34</td>
                  <td>Up to 15% on various services</td>
              </tr><tr>
                  <td>Consultation</td>
                  <td>R G Stone Hospitals</td>
                  <td>13</td>
                  <td>Up to 15% Discount on various services</td>
              </tr><tr>
                  <td>Consultation</td>
                  <td>Shalby Hospitals</td>
                  <td>6</td>
                  <td>Flat 10% discount on various services</td>
              </tr><tr>
                  <td>Genome Tests</td>
                  <td>Map my Genome</td>
                  <td>Online</td>
                  <td>Flat 40% discounts on genome tests</td>
              </tr>
              <tr>
                  <td>Onco. Second opinion</td>
                  <td>Cancer X</td>
                  <td>Online</td>
                  <td>Flat 20% discount on Onco. second opinion</td>
              </tr>
              <tr>
                  <td>Diagnostics</td>
                  <td>Core Diagnostic</td>
                  <td>120</td>
                  <td>Flat 20% discount on various services</td>
              </tr>
              <tr>
                  <td>Diagnostics</td>
                  <td>Dr. Lal Path</td>
                  <td>210</td>
                  <td>Flat 20% discount on various services</td>
              </tr>
              <tr>
                  <td>Diagnostics</td>
                  <td>SRL Diagnostic</td>
                  <td>23</td>
                  <td>Flat 20% discount on various services</td>
              </tr>
              <tr>
                  <td>Diagnostics</td>
                  <td>Surksha</td>
                  <td>37</td>
                  <td>Flat 20% discount on various services</td>
              </tr>
              <tr>
                  <td>Diagnostics</td>
                  <td>Pathcare</td>
                  <td>31</td>
                  <td>Flat 30% discount on various services</td>
              </tr>
              <tr>
                  <td>Diagnostics</td>
                  <td>Suburban Diagnostics</td>
                  <td>16</td>
                  <td>Up to 30% discount on various services</td>
              </tr>
              <tr>
                  <td>Pharmacy</td>
                  <td>Apollo Pharmacy</td>
                  <td>2500</td>
                  <td>Up to 15% on various services</td>
              </tr>
              <tr>
                  <td>Pharmacy</td>
                  <td>MedLife</td>
                  <td>Online</td>
                  <td>Flat 22% discount on various products</td>
              </tr>
              <tr>
                  <td>Dental</td>
                  <td>Clove Dental</td>
                  <td>214</td>
                  <td>Up to 20% discount on various services</td>
              </tr>
              <tr>
                  <td>Dental</td>
                  <td>My Dental Plan</td>
                  <td>750</td>
                  <td>Flat 40% discount on annual membership</td>
              </tr>
              
              
               
          </tbody>
         </table>


        </div>






</body>

</html>