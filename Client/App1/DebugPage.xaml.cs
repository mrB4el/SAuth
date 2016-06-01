using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices.WindowsRuntime;
using Windows.Data.Json;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.Storage.Streams;
using Windows.System.Profile;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;
using Windows.Web.Http;
using Windows.Security.Cryptography.Core;
using System.Text;
using System.Diagnostics;
using Windows.Security.Cryptography;
using System.Security;
using System.Reflection;

// Шаблон элемента пустой страницы задокументирован по адресу http://go.microsoft.com/fwlink/?LinkId=234238

namespace App1
{
    /// <summary>
    /// Пустая страница, которую можно использовать саму по себе или для перехода внутри фрейма.
    /// </summary>
    public sealed partial class DebugPage : Page
    {
        public DebugPage()
        {
            this.InitializeComponent();
        }

        private async void button_Click(object sender, RoutedEventArgs e)
        {
            var client = new HttpClient();

            string url = "http://localhost/test/index.php?type=get&login=admin&password=e10adc3949ba59abbe56e057f20f883e";

            HttpResponseMessage response = await client.GetAsync(new Uri(url));

            string jsonString = await response.Content.ReadAsStringAsync();
            JsonObject jsonObject = JsonObject.Parse(jsonString);

            string token = jsonObject.GetNamedString("token");
            string publickey = jsonObject.GetNamedString("publickey");
            string date = jsonObject.GetNamedString("date");

            //string publickey = "MIGJAoGBAKR0RB3X24esTXsETGqpUZU3BeKovg1R2OwxAL0vnSJE4tLs5woVqipMsGNGlWP+bfMjhdZOeVQ/Fk+R2quPVuV3lEwF7ow9BFqUlxxW0xHzj4RrpIC460pgDs8e3MYZt/4UignO0K4b2T2tl6GiB2UGk6QfNs6VuFp9+WKqtZvPAgMBAAE=";

            // byte[] byteArray = WinRTEncrypt(publickey, "hello");
            //string cipherdata = System.Text.Encoding.UTF8.GetString(byteArray);

            //string cipherdata = WinRTEncrypt(publickey, "MIGJAoGBAKR0RB3X24esTXsET");
            //textBox.Text = cipherdata;
            //http://localhost/test/index.php?type=set&cipherdata=cipherdata
            //http://localhost/test/index.php?type=set&cipherdata=cipherdata


            //textBlock.Text = await SendDevicename(token, "упячка");

            string pin = "1313";

            var data = new Dictionary<string, string>();
            data["type"] = "registration";
            data["token"] = token;
            data["devicename"] = "WIN10-PC";
            data["secret"] = ComputeMD5(ComputeMD5("Test") + pin);

            textBlock.Text = await PostData("http://localhost/test/index.php", data);

        }
        
        public string ComputeMD5(string str)
        {
            var alg = HashAlgorithmProvider.OpenAlgorithm(HashAlgorithmNames.Md5);
            IBuffer buff = CryptographicBuffer.ConvertStringToBinary(str, BinaryStringEncoding.Utf8);

            var hashed = alg.HashData(buff);
            var res = CryptographicBuffer.EncodeToHexString(hashed);

            return res;
        }


        public async System.Threading.Tasks.Task<string> PostData(string server, Dictionary<string, string> data)
        {

            string request = "";

            foreach (KeyValuePair<string, string> kvp in data)
            {
                request = request + "&" + kvp.Key + "=" + kvp.Value;
            }

            var client = new HttpClient();
            string url = server + "?" + request;

            HttpResponseMessage response = await client.GetAsync(new Uri(url));

            string answer = await response.Content.ReadAsStringAsync();

            return answer;
        }

        public static string WinRTEncrypt(string publicKey, string data)
        {
            IBuffer keyBuffer = CryptographicBuffer.DecodeFromBase64String(publicKey);

            AsymmetricKeyAlgorithmProvider asym = AsymmetricKeyAlgorithmProvider.OpenAlgorithm(AsymmetricAlgorithmNames.RsaPkcs1);

            CryptographicKey key = asym.ImportPublicKey(keyBuffer, CryptographicPublicKeyBlobType.Pkcs1RsaPublicKey);

            IBuffer plainBuffer = CryptographicBuffer.ConvertStringToBinary(data, BinaryStringEncoding.Utf8);
            IBuffer encryptedBuffer = CryptographicEngine.Encrypt(key, plainBuffer, null);

            string result = CryptographicBuffer.EncodeToBase64String(encryptedBuffer);

            result = Convert.ToString(encryptedBuffer);

            return result;
        }

        public async System.Threading.Tasks.Task<string> SendDevicename(string server, string type, string token, string devicename)
        {
            var client = new HttpClient();
            string url = "http://localhost/test/index.php?type=post&token=" + token + "&devicename=" + devicename;

            HttpResponseMessage response = await client.GetAsync(new Uri(url));

            string answer = await response.Content.ReadAsStringAsync();

            return answer;
        }

    }
}
