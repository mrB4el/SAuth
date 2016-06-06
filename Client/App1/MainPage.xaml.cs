using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Runtime.InteropServices.WindowsRuntime;
using Windows.Foundation;
using Windows.Foundation.Collections;
using Windows.UI.Xaml;
using Windows.UI.Xaml.Controls;
using Windows.UI.Xaml.Controls.Primitives;
using Windows.UI.Xaml.Data;
using Windows.UI.Xaml.Input;
using Windows.UI.Xaml.Media;
using Windows.UI.Xaml.Navigation;

// Документацию по шаблону элемента "Пустая страница" см. по адресу http://go.microsoft.com/fwlink/?LinkId=402352&clcid=0x409

namespace App1
{
    public class ClassTimer
    {
        public ClassTimer() { }

        private int current_time;

        public int status = 0; // 0 - stop, 1 - pause, 2 - working

        public void counter()
        {

        }
    }

    public class IsPinCodeSetCheck
    {
        public bool GetStatus()
        {
            bool result = false;

            //Frame.Navigate(typeof(Page2));

            return result;
        }
    }
    /// <summary>
    /// Пустая страница, которую можно использовать саму по себе или для перехода внутри фрейма.
    /// </summary>
    public sealed partial class MainPage : Page
    {
        public MainPage()
        {
            this.InitializeComponent();
        }

        private string pin = "";

        protected override void OnNavigatedTo(NavigationEventArgs e)
        {
            base.OnNavigatedTo(e);
            pin = e.Parameter as string;
            button_action.Content = pin;
        }


        ClassTimer Timer = new ClassTimer();

        private void button_action_Click(object sender, RoutedEventArgs e)
        {


            switch (Timer.status)
            {
                case 0:
                    Timer.counter();
                    break;

                case 1:
                    break;

                default:
                    break;

            }

        }

        private void AppBarButton_Click(object sender, RoutedEventArgs e)
        {
            Frame.Navigate(typeof(MainPage), pin);
        }
    }
}
