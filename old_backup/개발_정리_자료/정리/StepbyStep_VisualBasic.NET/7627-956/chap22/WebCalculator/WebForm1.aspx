<%@ Page Language="vb" AutoEventWireup="false" Codebehind="WebForm1.aspx.vb" Inherits="WebCalculator.WebForm1"%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<title>WebForm1</title>
		<meta content="Microsoft Visual Studio.NET 7.0" name="GENERATOR">
		<meta content="Visual Basic 7.0" name="CODE_LANGUAGE">
		<meta content="JavaScript" name="vs_defaultClientScript">
		<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">
	</HEAD>
	<body ms_positioning="GridLayout">
		<form id="Form1" method="post" runat="server">
			<P><STRONG><FONT size="5">Car Loan Calculator</FONT></STRONG></P>
			<P>
				<asp:TextBox id="txtAmount" style="Z-INDEX: 101; LEFT: 11px; POSITION: absolute; TOP: 102px" runat="server" Width="184px"></asp:TextBox>
				<asp:TextBox id="txtInterest" style="Z-INDEX: 102; LEFT: 12px; POSITION: absolute; TOP: 145px" runat="server" Width="183px"></asp:TextBox>
				<asp:TextBox id="txtPayment" style="Z-INDEX: 103; LEFT: 15px; POSITION: absolute; TOP: 188px" runat="server" Width="181px" Height="23px"></asp:TextBox>Enter 
				the required information and
				<asp:Label id="lblAmount" style="Z-INDEX: 104; LEFT: 207px; POSITION: absolute; TOP: 106px" runat="server" Width="155px" Height="22px">Loan Amount</asp:Label>
				click Calculate!
				<asp:Label id="lblInterest" style="Z-INDEX: 105; LEFT: 208px; POSITION: absolute; TOP: 145px" runat="server" Width="211px" Height="18px">Interest Rate (for example, 0.09)</asp:Label>
				<asp:Label id="lblPayment" style="Z-INDEX: 106; LEFT: 209px; POSITION: absolute; TOP: 189px" runat="server" Width="159px" Height="19px">Monthly Payment</asp:Label>
				<asp:Button id="btnCalculate" style="Z-INDEX: 107; LEFT: 19px; POSITION: absolute; TOP: 242px" runat="server" Width="100px" Height="25px" Text="Calculate"></asp:Button>
				<asp:HyperLink id="HyperLink1" style="Z-INDEX: 108; LEFT: 214px; POSITION: absolute; TOP: 245px" runat="server" Width="102px" Height="23px" NavigateUrl="WebCalculatorHelp.htm">Get Help</asp:HyperLink></P>
		</form>
	</body>
</HTML>
