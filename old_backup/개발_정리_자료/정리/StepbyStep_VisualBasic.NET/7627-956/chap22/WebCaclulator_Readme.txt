----------------------------------------------------------------------
WebCalculator
Chap22
----------------------------------------------------------------------


Description
===========
WebCalculator is an ASP.NET Web application to compute car loan
payments.



How To Configure and Test
=========================
Configuring and testing a Web application is more complicated than
compiling and testing a Windows application. To test the WebCalculator
application, it is recommended that you follow the steps in Chapter 22.
If you want to test the WebCalculator application provided in the 
practice files, carefully follow these steps:


1. Make sure Visual Studio .NET has the proper software installed 
     and is configured for ASP.NET programming as described in
     Chapter 22.
2. Using Windows Explorer, copy the WebCalculator folder to
     C:\Inetpub\wwwroot.
3. Open the Internet Information Services console.
     (Internet Services Manager in Administrative tools)
4. Expand the Default Web Site node.
5. Right-click the WebCalculator folder and select Properties.
     The WebCalculator Properties dialog box appears.
6. Under Application Settings, click the Create button to create
     a virtual directory for WebCalculator.
7. Under Local Path, make sure the Read checkbox is checked.
8. Click OK to close the WebCalculator Properties dialog box.
9. Using Windows Explorer, open C:\Inetpub\wwwroot\WebCalculator.
10. Double-click WebCalculator.sln to open the WebCalculator
     application in Visual Studio .NET.
     The WebCalculator application appears in Visual Studio .NET.
11. Right-click WebForm1.aspx in Solution Explorer and select
      Set As Start Page.
12. Click the Start button on the Standard toolbar.
      If everything is configured properly, the Car Loan Calculator
      page should appear in Internet Explorer.

