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
    Friend WithEvents GroupBox1 As System.Windows.Forms.GroupBox
    Friend WithEvents RadioButton1 As System.Windows.Forms.RadioButton
    Friend WithEvents RadioButton2 As System.Windows.Forms.RadioButton
    Friend WithEvents RadioButton3 As System.Windows.Forms.RadioButton
    Friend WithEvents GroupBox2 As System.Windows.Forms.GroupBox
    Friend WithEvents CheckBox1 As System.Windows.Forms.CheckBox
    Friend WithEvents CheckBox2 As System.Windows.Forms.CheckBox
    Friend WithEvents CheckBox3 As System.Windows.Forms.CheckBox
    Friend WithEvents ListBox1 As System.Windows.Forms.ListBox
    Friend WithEvents Label4 As System.Windows.Forms.Label
    Friend WithEvents ComboBox1 As System.Windows.Forms.ComboBox
    Friend WithEvents PictureBox1 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox2 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox3 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox4 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox5 As System.Windows.Forms.PictureBox
    Friend WithEvents PictureBox6 As System.Windows.Forms.PictureBox
    Friend WithEvents Button1 As System.Windows.Forms.Button

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        Me.Label4 = New System.Windows.Forms.Label()
        Me.Label1 = New System.Windows.Forms.Label()
        Me.Label2 = New System.Windows.Forms.Label()
        Me.Label3 = New System.Windows.Forms.Label()
        Me.Button1 = New System.Windows.Forms.Button()
        Me.ListBox1 = New System.Windows.Forms.ListBox()
        Me.GroupBox2 = New System.Windows.Forms.GroupBox()
        Me.CheckBox3 = New System.Windows.Forms.CheckBox()
        Me.CheckBox2 = New System.Windows.Forms.CheckBox()
        Me.CheckBox1 = New System.Windows.Forms.CheckBox()
        Me.ComboBox1 = New System.Windows.Forms.ComboBox()
        Me.RadioButton1 = New System.Windows.Forms.RadioButton()
        Me.RadioButton3 = New System.Windows.Forms.RadioButton()
        Me.RadioButton2 = New System.Windows.Forms.RadioButton()
        Me.PictureBox2 = New System.Windows.Forms.PictureBox()
        Me.PictureBox1 = New System.Windows.Forms.PictureBox()
        Me.PictureBox6 = New System.Windows.Forms.PictureBox()
        Me.PictureBox5 = New System.Windows.Forms.PictureBox()
        Me.PictureBox4 = New System.Windows.Forms.PictureBox()
        Me.GroupBox1 = New System.Windows.Forms.GroupBox()
        Me.PictureBox3 = New System.Windows.Forms.PictureBox()
        Me.GroupBox2.SuspendLayout()
        Me.GroupBox1.SuspendLayout()
        Me.SuspendLayout()
        '
        'Label4
        '
        Me.Label4.Location = New System.Drawing.Point(192, 88)
        Me.Label4.Name = "Label4"
        Me.Label4.Size = New System.Drawing.Size(120, 16)
        Me.Label4.TabIndex = 6
        Me.Label4.Text = "Peripherals (one only)"
        '
        'Label1
        '
        Me.Label1.Font = New System.Drawing.Font("Microsoft Sans Serif", 18!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label1.Location = New System.Drawing.Point(8, 8)
        Me.Label1.Name = "Label1"
        Me.Label1.Size = New System.Drawing.Size(248, 32)
        Me.Label1.TabIndex = 0
        Me.Label1.Text = "The Online Shopper"
        '
        'Label2
        '
        Me.Label2.Font = New System.Drawing.Font("Microsoft Sans Serif", 8!)
        Me.Label2.Location = New System.Drawing.Point(8, 40)
        Me.Label2.Name = "Label2"
        Me.Label2.Size = New System.Drawing.Size(320, 32)
        Me.Label2.TabIndex = 1
        Me.Label2.Text = "Outfit your office now by choosing the office products you need using radio butto" & _
        "ns, check boxes, a list box, and a combo box."
        '
        'Label3
        '
        Me.Label3.Font = New System.Drawing.Font("Microsoft Sans Serif", 12!, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, CType(0, Byte))
        Me.Label3.Location = New System.Drawing.Point(344, 40)
        Me.Label3.Name = "Label3"
        Me.Label3.Size = New System.Drawing.Size(136, 24)
        Me.Label3.TabIndex = 2
        Me.Label3.Text = "Products Ordered"
        '
        'Button1
        '
        Me.Button1.Location = New System.Drawing.Point(208, 256)
        Me.Button1.Name = "Button1"
        Me.Button1.Size = New System.Drawing.Size(80, 24)
        Me.Button1.TabIndex = 14
        Me.Button1.Text = "Quit"
        '
        'ListBox1
        '
        Me.ListBox1.Location = New System.Drawing.Point(192, 104)
        Me.ListBox1.Name = "ListBox1"
        Me.ListBox1.Size = New System.Drawing.Size(120, 69)
        Me.ListBox1.TabIndex = 5
        '
        'GroupBox2
        '
        Me.GroupBox2.Controls.AddRange(New System.Windows.Forms.Control() {Me.CheckBox3, Me.CheckBox2, Me.CheckBox1})
        Me.GroupBox2.Location = New System.Drawing.Point(8, 200)
        Me.GroupBox2.Name = "GroupBox2"
        Me.GroupBox2.Size = New System.Drawing.Size(168, 104)
        Me.GroupBox2.TabIndex = 4
        Me.GroupBox2.TabStop = False
        Me.GroupBox2.Text = "Office Equipment (0-3)"
        '
        'CheckBox3
        '
        Me.CheckBox3.Location = New System.Drawing.Point(16, 72)
        Me.CheckBox3.Name = "CheckBox3"
        Me.CheckBox3.Size = New System.Drawing.Size(130, 16)
        Me.CheckBox3.TabIndex = 2
        Me.CheckBox3.Text = "Copy machine"
        '
        'CheckBox2
        '
        Me.CheckBox2.Location = New System.Drawing.Point(16, 48)
        Me.CheckBox2.Name = "CheckBox2"
        Me.CheckBox2.Size = New System.Drawing.Size(130, 16)
        Me.CheckBox2.TabIndex = 1
        Me.CheckBox2.Text = "Calculator"
        '
        'CheckBox1
        '
        Me.CheckBox1.Location = New System.Drawing.Point(16, 24)
        Me.CheckBox1.Name = "CheckBox1"
        Me.CheckBox1.Size = New System.Drawing.Size(130, 16)
        Me.CheckBox1.TabIndex = 0
        Me.CheckBox1.Text = "Answering Machine"
        '
        'ComboBox1
        '
        Me.ComboBox1.DropDownWidth = 120
        Me.ComboBox1.Location = New System.Drawing.Point(192, 208)
        Me.ComboBox1.Name = "ComboBox1"
        Me.ComboBox1.Size = New System.Drawing.Size(120, 21)
        Me.ComboBox1.TabIndex = 7
        Me.ComboBox1.Text = "Payment Method"
        '
        'RadioButton1
        '
        Me.RadioButton1.Checked = True
        Me.RadioButton1.Location = New System.Drawing.Point(16, 24)
        Me.RadioButton1.Name = "RadioButton1"
        Me.RadioButton1.Size = New System.Drawing.Size(130, 16)
        Me.RadioButton1.TabIndex = 0
        Me.RadioButton1.TabStop = True
        Me.RadioButton1.Text = "PC"
        '
        'RadioButton3
        '
        Me.RadioButton3.Location = New System.Drawing.Point(16, 72)
        Me.RadioButton3.Name = "RadioButton3"
        Me.RadioButton3.Size = New System.Drawing.Size(130, 16)
        Me.RadioButton3.TabIndex = 2
        Me.RadioButton3.Text = "Laptop"
        '
        'RadioButton2
        '
        Me.RadioButton2.Location = New System.Drawing.Point(16, 48)
        Me.RadioButton2.Name = "RadioButton2"
        Me.RadioButton2.Size = New System.Drawing.Size(130, 16)
        Me.RadioButton2.TabIndex = 1
        Me.RadioButton2.Text = "Macintosh"
        '
        'PictureBox2
        '
        Me.PictureBox2.Location = New System.Drawing.Point(432, 80)
        Me.PictureBox2.Name = "PictureBox2"
        Me.PictureBox2.Size = New System.Drawing.Size(72, 56)
        Me.PictureBox2.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox2.TabIndex = 9
        Me.PictureBox2.TabStop = False
        '
        'PictureBox1
        '
        Me.PictureBox1.Location = New System.Drawing.Point(328, 80)
        Me.PictureBox1.Name = "PictureBox1"
        Me.PictureBox1.Size = New System.Drawing.Size(80, 56)
        Me.PictureBox1.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox1.TabIndex = 8
        Me.PictureBox1.TabStop = False
        '
        'PictureBox6
        '
        Me.PictureBox6.Location = New System.Drawing.Point(424, 216)
        Me.PictureBox6.Name = "PictureBox6"
        Me.PictureBox6.Size = New System.Drawing.Size(80, 64)
        Me.PictureBox6.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox6.TabIndex = 13
        Me.PictureBox6.TabStop = False
        '
        'PictureBox5
        '
        Me.PictureBox5.Location = New System.Drawing.Point(328, 224)
        Me.PictureBox5.Name = "PictureBox5"
        Me.PictureBox5.Size = New System.Drawing.Size(80, 56)
        Me.PictureBox5.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox5.TabIndex = 12
        Me.PictureBox5.TabStop = False
        '
        'PictureBox4
        '
        Me.PictureBox4.Location = New System.Drawing.Point(424, 144)
        Me.PictureBox4.Name = "PictureBox4"
        Me.PictureBox4.Size = New System.Drawing.Size(80, 64)
        Me.PictureBox4.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox4.TabIndex = 11
        Me.PictureBox4.TabStop = False
        '
        'GroupBox1
        '
        Me.GroupBox1.Controls.AddRange(New System.Windows.Forms.Control() {Me.RadioButton3, Me.RadioButton2, Me.RadioButton1})
        Me.GroupBox1.Location = New System.Drawing.Point(8, 80)
        Me.GroupBox1.Name = "GroupBox1"
        Me.GroupBox1.Size = New System.Drawing.Size(168, 104)
        Me.GroupBox1.TabIndex = 3
        Me.GroupBox1.TabStop = False
        Me.GroupBox1.Text = "Computer (required)"
        '
        'PictureBox3
        '
        Me.PictureBox3.Location = New System.Drawing.Point(328, 152)
        Me.PictureBox3.Name = "PictureBox3"
        Me.PictureBox3.Size = New System.Drawing.Size(80, 56)
        Me.PictureBox3.SizeMode = System.Windows.Forms.PictureBoxSizeMode.StretchImage
        Me.PictureBox3.TabIndex = 10
        Me.PictureBox3.TabStop = False
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(512, 325)
        Me.Controls.AddRange(New System.Windows.Forms.Control() {Me.Button1, Me.PictureBox6, Me.PictureBox5, Me.PictureBox4, Me.PictureBox3, Me.PictureBox2, Me.PictureBox1, Me.ComboBox1, Me.Label4, Me.ListBox1, Me.GroupBox2, Me.GroupBox1, Me.Label3, Me.Label2, Me.Label1})
        Me.Name = "Form1"
        Me.Text = "Online Shopper"
        Me.GroupBox2.ResumeLayout(False)
        Me.GroupBox1.ResumeLayout(False)
        Me.ResumeLayout(False)

    End Sub

#End Region

    Private Sub Form1_Load(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles MyBase.Load
        'These program statements run when the form loads
        PictureBox1.Image = System.Drawing.Image.FromFile _
          ("c:\vbnetsbs\chap03\input controls\pcomputr.bmp")
        'Add items to a list box like this:
        ListBox1.Items.Add("Extra hard disk")
        ListBox1.Items.Add("Printer")
        ListBox1.Items.Add("Satellite dish")
        'Combo boxes are also filled with the Add method:
        ComboBox1.Items.Add("U.S. Dollars")
        ComboBox1.Items.Add("Check")
        ComboBox1.Items.Add("English Pounds")
    End Sub

    Private Sub RadioButton1_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles RadioButton1.CheckedChanged
        PictureBox1.Image = System.Drawing.Image.FromFile _
          ("c:\vbnetsbs\chap03\input controls\pcomputr.bmp")
    End Sub

    Private Sub RadioButton2_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles RadioButton2.CheckedChanged
        PictureBox1.Image = System.Drawing.Image.FromFile _
          ("c:\vbnetsbs\chap03\input controls\computer.bmp")
    End Sub

    Private Sub RadioButton3_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles RadioButton3.CheckedChanged
        PictureBox1.Image = System.Drawing.Image.FromFile _
          ("c:\vbnetsbs\chap03\input controls\laptop1.bmp")
    End Sub

    Private Sub Button1_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles Button1.Click
        'This event procedure ends the program when Quit is clicked
        End
    End Sub

    Private Sub ListBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ListBox1.SelectedIndexChanged
        'The item you picked (0-2) is held in the SelectedIndex property
        Select Case ListBox1.SelectedIndex
            Case 0
                PictureBox3.Image = System.Drawing.Image.FromFile _
                  ("c:\vbnetsbs\chap03\input controls\harddisk.bmp")
            Case 1
                PictureBox3.Image = System.Drawing.Image.FromFile _
                  ("c:\vbnetsbs\chap03\input controls\printer.bmp")
            Case 2
                PictureBox3.Image = System.Drawing.Image.FromFile _
                  ("c:\vbnetsbs\chap03\input controls\satedish.bmp")
        End Select
    End Sub

    Private Sub CheckBox1_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CheckBox1.CheckedChanged
        'If the CheckState property for a check box is 1, it has a mark in it
        If CheckBox1.CheckState = 1 Then
            PictureBox2.Image = System.Drawing.Image.FromFile _
              ("c:\vbnetsbs\chap03\input controls\answmach.bmp")
            PictureBox2.Visible = True
        Else
            'If there is no mark, hide the image
            PictureBox2.Visible = False
        End If
    End Sub

    Private Sub CheckBox2_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CheckBox2.CheckedChanged
        If CheckBox2.CheckState = 1 Then
            PictureBox4.Image = System.Drawing.Image.FromFile _
              ("c:\vbnetsbs\chap03\input controls\calcultr.bmp")
            PictureBox4.Visible = True
        Else
            PictureBox4.Visible = False
        End If
    End Sub

    Private Sub CheckBox3_CheckedChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CheckBox3.CheckedChanged
        If CheckBox3.CheckState = 1 Then
            PictureBox6.Image = System.Drawing.Image.FromFile _
              ("c:\vbnetsbs\chap03\input controls\copymach.bmp")
            PictureBox6.Visible = True
        Else
            PictureBox6.Visible = False
        End If
    End Sub

    Private Sub ComboBox1_SelectedIndexChanged(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles ComboBox1.SelectedIndexChanged
        'The selected list item (numbered 0-2) is stored in the SelectedIndex property
        Select Case ComboBox1.SelectedIndex
            Case 0
                PictureBox5.Image = System.Drawing.Image.FromFile _
                  ("c:\vbnetsbs\chap03\input controls\dollar.bmp")
            Case 1
                PictureBox5.Image = System.Drawing.Image.FromFile _
                  ("c:\vbnetsbs\chap03\input controls\check.bmp")
            Case 2
                PictureBox5.Image = System.Drawing.Image.FromFile _
                  ("c:\vbnetsbs\chap03\input controls\poundbag.bmp")
        End Select
    End Sub
End Class
