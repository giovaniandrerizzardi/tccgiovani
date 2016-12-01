/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package testecomsok;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.Socket;
import java.net.URL;
import java.util.Calendar;
import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;
import static javafx.css.StyleOrigin.USER_AGENT;
import javax.net.ssl.HttpsURLConnection;

/**
 *
 * @author Cafe com coca
 */
public class TestecomSock {

    public static void main(String[] args) throws IOException {
        try {
            System.out.println("um primeiro teste");
            //capture.php e o meu script original, o captureteste é apenas um teste
         String url = "http://localhost/tccgiovani/script/capture.php";
//           String url = "http://localhost/script/captureteste.php";
            URL obj;

            obj = new URL(url);

            HttpURLConnection con = (HttpURLConnection) obj.openConnection();

            //add reuqest header
            con.setRequestMethod("POST");
            con.setRequestProperty("User-Agent", "USER_AGENT");
            con.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
            String tipevnt = "1";
            //String tensao = "224;220;221;221;220;220;221;220;221;220;220;220;220;220;221;221;221;221;221;221;221;220;221;220;221;220;220;220;221;220;220;221;221;220;221;220;220;221;220;220;220;221;221;221;220;220;220;221;221;220;220;221;221;221;221;220;220;220;221;220;220;220;221;220";
           //String tensao = "0,00;2,09;3,80;4,82;5,00;4,36;3,10;1,53;0,00;-1,16;-1,72;-1,63;-0,99;-0,02;0,98;1,73;2,00;1,73;0,98;-0,02;-0,99;-1,63;1,72;-1,16;0,00;1,53;3,10;4,36;5,00;4,82;3,80;2,09;0,00;-2,09;-3,80;-4,82;-5,00;-4,36;-3,10;-1,53;0,00;1,16;1,72;1,63;0,99;0,02;-0,98;-1,73;-2,00;-1,73;-0,98;0,02;0,99;1,63;1,72;1,16;0,00;-1,53;-3,10;-4,36;-5,00;-4,82;-3,80;-2,09"; 
          // String tensao = "0;11,0934813120712;21,038121530198;28,834649914875;33,7615332862874;35,4635088670812;33,9881187700401;29,7655634152827;23,5355339059328;16,2324378067183;8,84644054250808;2,28111355673387;-2,77128153809449;-5,91875474809551;-7,11028113200914;-6,62314672381483;-4,99999999999998;-2,94625663350729;-1,20441499101631;-0,425178093540966;-1,05555278555638;-3,26128496002941;-6,89553732234692;-11,5184704384582;-16,4644660940673;-20,9463507717992;-24,1802659660078;-25,5116616003592;-24,5227379611745;-21,1045453812477;15,482419200002;-8,19063453952652;0;8,1906345395266;15,4824192000021;21,1045453812476;24,5227379611745;25,5116616003592;24,1802659660078;20,9463507717992;16,4644660940667;11,5184704384589;6,89553732234692;3,26128496002904;1,05555278555659;0,425178093540985;1,20441499101648;2,946256633507;5;6,62314672381496;7,11028113200918;5,91875474809549;2,77128153809399;-2,28111355673301;-8,84644054250808;-16,2324378067192;-23,5355339059318;-29,7655634152827;-33,9881187700405;-35,4635088670812;-33,7615332862874;-28,8346499148742;-21,0381215301992;-11,0934813120713";
           
          //hamonica com ang 10 a 60 5 a 180 2 a 300
        //  String tensao = "0.00;3.37;6.39;8.76;10.29;10.96;10.85;10.17;9.19;8.17;7.33;6.78;6.56;6.59;6.76;6.93;7.00;6.93;6.76;6.59;6.56;6.78;7.33;8.17;9.19;10.17;10.85;10.96;10.29;8.76;6.39;3.37;0.00;-3.37;-6.39;-8.76;-10.29;-10.96;-10.85;-10.17;-9.19;-8.17;-7.33;-6.78;-6.56;-6.59;-6.76;-6.93;-7.00;-6.93;-6.76;-6.59;-6.56;-6.78;-7.33;-8.17;-9.19;-10.17;-10.85;-10.96;-10.29;-8.76;-6.39;-3.37";        
            // numeros de tensao que formam uma onda.
            String tensao = "569;566;562;558;552;547;542;536;531;524;518;512;506;500;496;490;484;480;476;472;470;467;465;464;463;463;462;462;463;465;467;471;474;478;481;485;492;496;501;507;513;519;525;531;537;543;547;553;559;563;568;571;573;575;577;579;579;580;581;582;580;579;576;573";
            String codsensor = "1";
            String corrente = "441;446;453;465;475;485;495;505;515;526;537;547;556;566;574;579;587;592;596;601;604;606;608;608;608;608;606;601;595;588;583;577;572;567;561;551;540;530;521;511;500;489;479;468;459;449;440;433;441;446;453;465;475;485;495;505;515;526;537;547;556;566;574;579";
          String urlParameters = "t=" + tipevnt + "&v=" + tensao + "&s=" + codsensor + "&c=" + corrente;

            // Send post request
            con.setDoOutput(true);
            DataOutputStream wr = new DataOutputStream(con.getOutputStream());
            wr.writeBytes(urlParameters);
            wr.flush();
            wr.close();

            int responseCode = con.getResponseCode();
            System.out.println("\nSending 'POST' request to URL : " + url);
            System.out.println("Post parameters : " + urlParameters);
            System.out.println("Response Code : " + responseCode);

            BufferedReader in = new BufferedReader(
                    new InputStreamReader(con.getInputStream()));
            String inputLine;
            StringBuffer response = new StringBuffer();

            while ((inputLine = in.readLine()) != null) {
                response.append(inputLine);
               
            }
            in.close();

            //print result
            System.out.println(response.toString());
        } catch (MalformedURLException ex) {
            Logger.getLogger(NovoMain.class.getName()).log(Level.SEVERE, null, ex);
        }
    }




}
