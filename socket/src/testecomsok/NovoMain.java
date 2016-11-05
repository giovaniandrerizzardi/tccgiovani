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
public class NovoMain {

    public static void main(String[] args) throws IOException {
        try {
            System.out.println("um primeiro teste");
            String url = "http://localhost/script/capture.php";
            URL obj;

            obj = new URL(url);

            HttpURLConnection con = (HttpURLConnection) obj.openConnection();

            //add reuqest header
            con.setRequestMethod("POST");
            con.setRequestProperty("User-Agent", "USER_AGENT");
            con.setRequestProperty("Accept-Language", "en-US,en;q=0.5");
            String tipevnt = "2";
            String tensao = geravalores(64, 20, 430);
            String codsensor = "1";
            String corrente = geravalores(64, 4, 530);

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

    private static String geravalores(int N, int max, int inc) {
        Random r = new Random(Calendar.getInstance().getTimeInMillis());
        int val;
        String ret = new String();
        for (int i = 0; i < N; i++) {
            val = r.nextInt(max) + inc;
            ret += String.valueOf(val);
            if (i != N - 1) {
                ret += ";";
            }

        }
        return ret;
    }
;

}
