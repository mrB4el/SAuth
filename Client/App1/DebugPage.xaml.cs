using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices.WindowsRuntime;
using Windows.Data.Json;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;
using Windows.Web.Http;

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

            string url = textBox.Text;

            HttpResponseMessage response = await client.GetAsync(new Uri(url));

            string jsonString = await response.Content.ReadAsStringAsync();

            //JsonValue value = JsonValue.Parse(jsonString);

            JsonObject test1 = JsonObject.Parse(jsonString);

            JsonObject publickey = test1.GetNamedValue("publickey").GetObject();
            JsonObject token = test1.GetNamedValue("token").GetObject();

            textBlock.Text = jsonString + publickey.ToString() + token.ToString();
        }
    }
}
