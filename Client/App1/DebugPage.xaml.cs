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

            //HttpResponseMessage response = await client.GetAsync(new Uri(url));

            //string jsonString = await response.Content.ReadAsStringAsync();
            //JsonObject jsonObject = JsonObject.Parse(jsonString);

            //string token = jsonObject.GetNamedString("token");
            //string publickey = jsonObject.GetNamedString("publickey");

            //string publickey = "MIGJAoGBAK+0yr1Dl3Ip3olGgi5R5PL9ikwpnUghCNZR7zMGfHOQeX8sjGn1GArIHJN1A14p1rKGAn8E5fa+u6t8CQ5nGhZHTw0ZmJCPzYEmOOIEh7Ne8b8JQhXZbcO4HydO5g5DViRGk/3frKVY6fngIkoD8rgZsUDvQITy9eRFl3NifqqFAgMBAAE=";

            string publickey = "MIGJAoGBAKR0RB3X24esTXsETGqpUZU3BeKovg1R2OwxAL0vnSJE4tLs5woVqipMsGNGlWP+bfMjhdZOeVQ/Fk+R2quPVuV3lEwF7ow9BFqUlxxW0xHzj4RrpIC460pgDs8e3MYZt/4UignO0K4b2T2tl6GiB2UGk6QfNs6VuFp9+WKqtZvPAgMBAAE=";

            // byte[] byteArray = WinRTEncrypt(publickey, "hello");
            //string cipherdata = System.Text.Encoding.UTF8.GetString(byteArray);

            string cipherdata = WinRTEncrypt(publickey, "MIGJAoGBAKR0RB3X24esTXsET");

            //string result = doit(publickey, "hello");

            //http://localhost/test/index.php?type=set&cipherdata=cipherdata

            //string url = "http://localhost/test/index.php?type=set&cipherdata=";
            //url+=cipherdata;
            //HttpResponseMessage response = await client.GetAsync(new Uri(url));

            //string result = response.ToString();

            textBox.Text = cipherdata;
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

        
    }
}
