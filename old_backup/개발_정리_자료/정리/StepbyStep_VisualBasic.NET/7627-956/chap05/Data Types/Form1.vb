Public Class Form1
    Inherits System.Windows.Forms.Form

#Region " Windows Form Designer generated code "

    Public Sub New()
        MyBase.New()

        'This call is required by the Windows Form Designer.
        InitializeComponent()

        'Add any initialization after the InitializeComponent() call

    End Sub

    'Form overrides dispose to clean up the component list.
    Protected Overloads Overrides Sub Dispose(ByVal disposing As Boolean)
        If disposing Then
            If Not (components Is Nothing) Then
                components.Dispose()
            End If
        End If
        MyBase.Dispose(disposing)
    End Sub
    Friend WithEvents Label1 As System.Windows.Forms.Label
    Friend WithEvents Label2 As System.Windows.Forms.Label
    Friend WithEvents Label3 As System.Windows.Forms.Label
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents ListBox1 As System.Windows.Forms.ListBox
    Friend WithEvents Button1 As System.Windows.Forms.Button

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.ListBox1 = New System.Windows.Forms.ListBox()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.SuspendLayout()
        '
        'Label1
        '
        Me.Label1.Font = New System.Drawing.Font("Times New Roman", 15.75!, System.Drawing.FontStyle.Bold, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(112, 16)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(256, 32)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "Fundamental Data Types"
        '
        'Label2
        '
        Me.Label2.Location = New System.Drawing.Point(32, 64)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(168, 16)
        Me.Label2.TabIndex = 1
        Me.Label2.Text = "Choose a data type"
        '
        'Label3
        '
        Me.Label3.Location = New System.Drawing.Point(256, 64)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(144, 16)
        Me.Label3.TabIndex = 2
        Me.Label3.Text = "Sample Data"
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(304, 208)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(80, 24)
        Me.Button1.TabIndex = 5
        Me.Button1.Text = "Quit"
        '
        'ListBox1
        '
        Me.ListBox1.Location = New System.Drawing.Point(32, 80)
        Me.ListBox1.Name = "ListBox1"
        Me.ListBox1.Size = New System.Drawing.Size(176, 147)
        Me.ListBox1.TabIndex = 4
        '
        'Label4
        '
        Me.Label4.BorderStyle = System.Windows.Forms.BorderStyle.Fixed3D
        Me.Label4.Location = New System.Drawing.Point(256, 80)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(176, 24)
        Me.Label4.TabIndex = 3
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(472, 261)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Button1, Me.ListBox1, Me.Label4, Me.Label3, Me.Label2, Me.Label1})
        Me.Name = "Form1"
        Me.Text = "Data Type Tester"
        Me.ResumeLayout(False)

    End Sub

#End Region
    'Declare variables here so that they can be used in
    'all of this form's event procedures
    Dim Birds As Short
    Dim Insects As Integer
    Dim WorldPop As Long
    Dim Price As Single
    Dim Pi As Double
    Dim Debt As Decimal
    Dim RetKey As Byte
    Dim UnicodeChar As Char
    Dim Dog As String
    Dim Flag As Boolean
    Dim Birthday As Date
    
    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        End
    End Sub

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'add names to the list box (see chapter 3)
        ListBox1.Items.Add("Short")
        ListBox1.Items.Add("Integer")
        ListBox1.Items.Add("Long")
        ListBox1.Items.Add("Single")
        ListBox1.Items.Add("Double")
        ListBox1.Items.Add("Decimal")
        ListBox1.Items.Add("Byte")
        ListBox1.Items.Add("Char")
        ListBox1.Items.Add("String")
        ListBox1.Items.Add("Boolean")
        ListBox1.Items.Add("Date")
    End Sub

    Private Sub ListBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ListBox1.SelectedIndexChanged
        Select Case ListBox1.SelectedIndex
            Case 0
                Birds = 12500
                Label4.Text = Birds
            Case 1
                Insects = 37500000
                Label4.Text = Insects
            Case 2
                WorldPop = 4800000004
                Label4.Text = WorldPop
            Case 3
                Price = 899.99
                Label4.Text = Price
            Case 4
                Pi = 3.1415926535
                Label4.Text = Pi
            Case 5
                Debt = 7600300.5
                Label4.Text = Debt
            Case 6
                RetKey = 13
                Label4.Text = RetKey
            Case 7
                UnicodeChar = "?
                Label4.Text = UnicodeChar
            Case 8
                Dog = "pointer"
                Label4.Text = Dog
            Case 9
                Flag = True
                Label4.Text = Flag
            Case 10
                Birthday = #3/1/1963#
                Label4.Text = Birthday
        End Select
    End Sub
End Class
