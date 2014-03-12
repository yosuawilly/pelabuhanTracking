/**
 * 
 */
package com.tracking.kapal.restfull;

import java.net.SocketException;
import java.net.SocketTimeoutException;
import java.security.KeyStore;

import org.apache.http.HttpVersion;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.ResponseHandler;
import org.apache.http.client.methods.HttpDelete;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpPut;
import org.apache.http.client.methods.HttpUriRequest;
import org.apache.http.conn.ClientConnectionManager;
import org.apache.http.conn.ConnectTimeoutException;
import org.apache.http.conn.scheme.PlainSocketFactory;
import org.apache.http.conn.scheme.Scheme;
import org.apache.http.conn.scheme.SchemeRegistry;
import org.apache.http.conn.ssl.SSLSocketFactory;
import org.apache.http.impl.client.BasicResponseHandler;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.impl.conn.tsccm.ThreadSafeClientConnManager;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.params.HttpProtocolParams;
import org.apache.http.protocol.HTTP;

import com.tracking.kapal.util.Constant;

import android.util.Log;

/**
 * @author Dwidasa
 * 10:59:04 AM
 */
public class RestfulHttpMethod {
	private static int flag = 0;
	
	private static final String TAG = "RestfulHttpMethod";
	
	private RestfulHttpMethod() {
		// TODO Auto-generated constructor stub
	}
	
    public static String connect(String url, int method) throws ClientProtocolException, SocketException , SocketTimeoutException, ConnectTimeoutException, Exception{     	   
    	String result = "{\"errorCode\":\"LK-0000\"}";
    	if(flag == 1)
    		flag=1;    	
    	
    	HttpParams httpParameters = new BasicHttpParams();
    	// Set the timeout in milliseconds until a connection is established.
    	int timeoutConnection = 60000;
    	HttpConnectionParams.setConnectionTimeout(httpParameters, timeoutConnection);
    	
    	// Set the default socket timeout (SO_TIMEOUT) 
    	// in milliseconds which is the timeout for waiting for data.
    	int timeoutSocket = 60000;
    	HttpConnectionParams.setSoTimeout(httpParameters, timeoutSocket);
    	
    	// begin disable ssl certificate validation
        KeyStore trustStore = KeyStore.getInstance(KeyStore.getDefaultType());
        trustStore.load(null, null);
        SSLSocketFactory sf = new CustomSSLSocketFactory(trustStore);
        sf.setHostnameVerifier(SSLSocketFactory.ALLOW_ALL_HOSTNAME_VERIFIER);

        //HttpParams params = new BasicHttpParams();
        HttpProtocolParams.setVersion(httpParameters, HttpVersion.HTTP_1_1);
        HttpProtocolParams.setContentCharset(httpParameters, HTTP.UTF_8);

        SchemeRegistry registry = new SchemeRegistry();
        registry.register(new Scheme("http", PlainSocketFactory.getSocketFactory(), 80));
        registry.register(new Scheme("https", sf, 443));

        ClientConnectionManager ccm = new ThreadSafeClientConnManager(httpParameters, registry);
        // end of disable ssl

    	
       HttpClient httpclient = new DefaultHttpClient(ccm,httpParameters);
        

      //  HttpClient httpclient = new DefaultHttpClient(httpParameters);
//      HttpHost httpproxy = new HttpHost("192.168.85.1", 8888, "http");
//    	httpclient.getParams().setParameter(ConnRoutePNames.DEFAULT_PROXY,httpproxy);
        
    	//HttpGet request = new HttpGet(url);
        ResponseHandler<String> handler = new BasicResponseHandler();
        //you result will be String :
        
        HttpUriRequest request;
        switch (method) {
			case Constant.REST_GET:
				request = new HttpGet(url);
				break;
			case Constant.REST_PUT:
				request = new HttpPut(url);
				break;
			case Constant.REST_POST:
				request = new HttpPost(url);
				break;
			case Constant.REST_DELETE:
				request = new HttpDelete(url);
				break;
			default:
				request = new HttpGet(url);
				break;
		}
        Log.i(TAG, url);
        Log.i("request", request.toString());
        request.addHeader("Accept-Language", "ind");
        result = httpclient.execute(request, handler);	       
        Log.i(TAG, result);    
        return result;
    }
}
