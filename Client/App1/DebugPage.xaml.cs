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
            generate_temp_pin();
            //get_time();
        }

        private async void button1_Click(object sender, RoutedEventArgs e)
        {
            var client = new HttpClient();

            string url = "http://localhost/test/api/index.php?type=get&login=admin&password=e10adc3949ba59abbe56e057f20f883e";

            /*
            HttpResponseMessage response = await client.GetAsync(new Uri(url));

            string jsonString = await response.Content.ReadAsStringAsync();
            JsonObject jsonObject = JsonObject.Parse(jsonString);

            string token = jsonObject.GetNamedString("token");
            string publickey = jsonObject.GetNamedString("publickey");
            string date = jsonObject.GetNamedString("date");
            */
            //string publickey = "MIGJAoGBAKR0RB3X24esTXsETGqpUZU3BeKovg1R2OwxAL0vnSJE4tLs5woVqipMsGNGlWP+bfMjhdZOeVQ/Fk+R2quPVuV3lEwF7ow9BFqUlxxW0xHzj4RrpIC460pgDs8e3MYZt/4UignO0K4b2T2tl6GiB2UGk6QfNs6VuFp9+WKqtZvPAgMBAAE=";

            // byte[] byteArray = WinRTEncrypt(publickey, "hello");
            //string cipherdata = System.Text.Encoding.UTF8.GetString(byteArray);

            string publickey = "MIGJAoGBAKR0RB3X24esTXsETGqpUZU3BeKovg1R2OwxAL0vnSJE4tLs5woVqipMsGNGlWP+bfMjhdZOeVQ/Fk+R2quPVuV3lEwF7ow9BFqUlxxW0xHzj4RrpIC460pgDs8e3MYZt/4UignO0K4b2T2tl6GiB2UGk6QfNs6VuFp9+WKqtZvPAgMBAAE=";

            byte[] numbers = new byte[5] { 0x29, 0x29, 0x29, 0x29, 0x29 };

            string cipherdata = WinRTEncrypt1(numbers, publickey);
            //textBox.Text = cipherdata;

            var data = new Dictionary<string, string>();
            data["ciphertext"] = cipherdata;

            string answer = await GET_Query_Data("http://localhost/test/crypt.php", data);

            //IBuffer buffUTF8 = CryptographicBuffer.ConvertStringToBinary(answer, BinaryStringEncoding.Utf8);
            //String strUTF8 = CryptographicBuffer.ConvertBinaryToString(BinaryStringEncoding.Utf8, buffUTF8);

            textBox1.Text = answer;
            textBox2.Text = cipherdata;
            //textBox3.Text = CryptographicBuffer.ConvertBinaryToString(BinaryStringEncoding.Utf16BE, CryptographicBuffer.DecodeFromBase64String(cipherdata));

            //http://localhost/test/index.php?type=set&cipherdata=cipherdata
            //http://localhost/test/index.php?type=set&cipherdata=cipherdata

        }

        /// <summary>
        /// Запрос времени у сервера
        /// </summary>
        public async void get_time()
        {
            var reginfo = new Dictionary<string, string>();
            reginfo["type"] = "get_time";;

            string jsonString = await GET_Query_Data("http://localhost/test/api/index.php", reginfo);
            JsonObject jsonObject = JsonObject.Parse(jsonString);

            string time = jsonObject.GetNamedString("time");

            textBlock1.Text = "Server answer 1";
            textBox1.Text = jsonString;

            DateTime server_date = DateTime.Parse(time, System.Globalization.CultureInfo.InvariantCulture);

            string t = server_date.ToString("HH:mm:ss tt");

            textBlock2.Text = "Server Time";
            textBox2.Text = server_date.ToString();

            DateTime localDate = DateTime.Now;
            

            textBlock3.Text = "Current Time";
            textBox3.Text = localDate.ToString("HH:mm");

            Windows.Storage.ApplicationDataContainer localSettings = Windows.Storage.ApplicationData.Current.LocalSettings;

            // Create a setting in a container

            Windows.Storage.ApplicationDataContainer container = localSettings.CreateContainer("DataDiffierences", Windows.Storage.ApplicationDataCreateDisposition.Always);

            if (localSettings.Containers.ContainsKey("DataDiffierences"))
            {
                localSettings.Containers["DataDiffierences"].Values["Minute"] = localDate.Minute - server_date.Minute;
                localSettings.Containers["DataDiffierences"].Values["Second"] = localDate.Second- server_date.Second;
                localSettings.Containers["DataDiffierences"].Values["Millisecond"] = localDate.Millisecond - server_date.Millisecond;
            }
        }
        public void generate_temp_pin()
        {
            string pin = "1313";

            string secret = ComputeMD5(ComputeMD5("Test") + pin);

            DateTime localDate = DateTime.Now;

            string timestamp = localDate.ToUniversalTime().ToString("HH:mm");

            string result = ComputeMD5(secret + timestamp);

            

            textBlock1.Text = "MD5";
            textBox1.Text = result;

            textBlock2.Text = "PIN";
            textBox2.Text = magic(result, 6);

            textBlock3.Text = "Time";
            textBox3.Text = timestamp;
        }

        /// <summary>
        /// Функция усечения хэша MD5
        /// </summary>
        /// <param name="MD5hash">MD5 хэш</param>
        /// <param name="size">Количество символов выходного значения</param>
        /// <returns></returns>

        public string magic(string MD5hash, int size)
        {
            string result = "";

            MD5hash = MD5hash.Replace("a", "1");
            MD5hash = MD5hash.Replace("b", "2");
            MD5hash = MD5hash.Replace("c", "3");
            MD5hash = MD5hash.Replace("d", "4");
            MD5hash = MD5hash.Replace("e", "5");
            MD5hash = MD5hash.Replace("f", "6");

            result = MD5hash.Remove(0, MD5hash.Length - size);

            return result;
        }
        
        /// <summary>
        /// Тест регистрации устройства
        /// </summary>
        public async void test_registration()
        {
            var reginfo = new Dictionary<string, string>();
            reginfo["type"] = "token_generate";
            reginfo["login"] = "admin";
            reginfo["password"] = "e10adc3949ba59abbe56e057f20f883e";

            string jsonString = await GET_Query_Data("http://localhost/test/api/index.php", reginfo);
            JsonObject jsonObject = JsonObject.Parse(jsonString);

            string token = jsonObject.GetNamedString("token");
            string publickey = jsonObject.GetNamedString("publickey");
            string date = jsonObject.GetNamedString("date");

            textBlock1.Text = "Server answer 1";
            textBox1.Text = jsonString;

            string pin = "1313";

            var data = new Dictionary<string, string>();
            data["type"] = "registration";
            data["token"] = token;
            data["devicename"] = "WIN10-PC";
            data["secret"] = ComputeMD5(ComputeMD5("Test") + pin);

            textBlock2.Text = "Server answer 2";
            textBox2.Text = await GET_Query_Data("http://localhost/test/api/index.php", data);
        }

        public string ComputeMD5(string str)
        {
            var alg = HashAlgorithmProvider.OpenAlgorithm(HashAlgorithmNames.Md5);
            IBuffer buff = CryptographicBuffer.ConvertStringToBinary(str, BinaryStringEncoding.Utf8);

            var hashed = alg.HashData(buff);
            var res = CryptographicBuffer.EncodeToHexString(hashed);

            return res;
        }


        public async System.Threading.Tasks.Task<string> GET_Query_Data(string server, Dictionary<string, string> data)
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
            string strIn = "Input String";

            IBuffer buffUTF8 = CryptographicBuffer.ConvertStringToBinary(strIn, BinaryStringEncoding.Utf8);
            String strUTF8 = CryptographicBuffer.ConvertBinaryToString(BinaryStringEncoding.Utf8, buffUTF8);

            IBuffer keyBuffer = CryptographicBuffer.DecodeFromBase64String(publicKey);

            AsymmetricKeyAlgorithmProvider asym = AsymmetricKeyAlgorithmProvider.OpenAlgorithm(AsymmetricAlgorithmNames.RsaPkcs1);
            //AsymmetricKeyAlgorithmProvider asym = AsymmetricKeyAlgorithmProvider.OpenAlgorithm(AsymmetricAlgorithmNames.RsaOaepSha256);

            CryptographicKey key = asym.ImportPublicKey(keyBuffer, CryptographicPublicKeyBlobType.Pkcs1RsaPublicKey);

            IBuffer plainBuffer = CryptographicBuffer.ConvertStringToBinary(strIn, BinaryStringEncoding.Utf8);
            IBuffer encryptedBuffer = CryptographicEngine.Encrypt(key, plainBuffer, null);


            //string result = CryptographicBuffer.EncodeToHexString(encryptedBuffer);

            //string result = CryptographicBuffer.ConvertBinaryToString(BinaryStringEncoding.Utf16LE, encryptedBuffer);

            string result = CryptographicBuffer.EncodeToBase64String(encryptedBuffer);

            return result;
        }

        public string WinRTEncrypt1(byte[] test, string publicKey)
        {
            string strIn = "))))";

            IBuffer plainBuffer = CryptographicBuffer.ConvertStringToBinary(strIn, BinaryStringEncoding.Utf8);

            strIn = CryptographicBuffer.EncodeToBase64String(plainBuffer);

            plainBuffer = CryptographicBuffer.ConvertStringToBinary(strIn, BinaryStringEncoding.Utf8);

            
            // <asymmetric>
            AsymmetricKeyAlgorithmProvider asym = AsymmetricKeyAlgorithmProvider.OpenAlgorithm(AsymmetricAlgorithmNames.RsaPkcs1);
            //AsymmetricKeyAlgorithmProvider asym = AsymmetricKeyAlgorithmProvider.OpenAlgorithm(AsymmetricAlgorithmNames.RsaOaepSha256);

            IBuffer keyBuffer = CryptographicBuffer.DecodeFromBase64String(publicKey);
            CryptographicKey key = asym.ImportPublicKey(keyBuffer, CryptographicPublicKeyBlobType.Pkcs1RsaPublicKey);
            IBuffer encryptedBuffer = CryptographicEngine.Encrypt(key, plainBuffer, null);
            // </asymmetric>
            
            /*
            // <symmetric>
            SymmetricKeyAlgorithmProvider sym = SymmetricKeyAlgorithmProvider.OpenAlgorithm(SymmetricAlgorithmNames.AesCbc);

            IBuffer temp_key = CryptographicBuffer.ConvertStringToBinary("1234567890", BinaryStringEncoding.Utf8);

            string keyblyad = CryptographicBuffer.EncodeToBase64String(temp_key);

            IBuffer key_buffer = CryptographicBuffer.ConvertStringToBinary(keyblyad, BinaryStringEncoding.Utf8);

            CryptographicKey key1 = sym.CreateSymmetricKey(key_buffer);
            IBuffer encryptedBuffer = CryptographicEngine.Encrypt(key1, plainBuffer, null);
            // </symmetric>
            */
           

            byte[] lole = encryptedBuffer.ToArray(); 

            string lol = "";

            for(int i=0; i < lole.Length; i++)
            {
                lol += (char)lole[i];
            }

            textBox3.Text = lol;

            //string result = CryptographicBuffer.EncodeToHexString(encryptedBuffer);

            //string result = CryptographicBuffer.ConvertBinaryToString(BinaryStringEncoding.Utf16LE, encryptedBuffer);

            string result = CryptographicBuffer.EncodeToBase64String(encryptedBuffer);

            //result = CryptographicBuffer.EncodeToBase64String(encryptedSymBuffer);

            //string result = CryptographicBuffer.EncodeToBase64String(buffUTF8);

            return result;
        }

    }
}
