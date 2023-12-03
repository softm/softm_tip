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

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.Container

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> Private Sub InitializeComponent()
        '
        'Form1
        '
        Me.AutoScaleBaseSize = New System.Drawing.Size(5, 13)
        Me.ClientSize = New System.Drawing.Size(416, 293)
        Me.Name = "Form1"
        Me.Text = "Draw Shapes"

    End Sub

#End Region

   
    Private Sub Form1_Paint(ByVal sender As Object, ByVal e As System.Windows.Forms.PaintEventArgs) Handles MyBase.Paint
        'Prepare GraphicsFun variable for graphics calls
        Dim GraphicsFun As System.Drawing.Graphics
        GraphicsFun = Me.CreateGraphics

        'Use a red pen color to draw a line and an ellipse
        Dim PenColor As New System.Drawing.Pen(System.Drawing.Color.Red)
        GraphicsFun.DrawLine(PenColor, 20, 30, 100, 80)
        GraphicsFun.DrawEllipse(PenColor, 10, 120, 200, 160)

        'Use a green brush color to create a filled rectangle
        Dim BrushColor As New SolidBrush(Color.Green)
        GraphicsFun.FillRectangle(BrushColor, 150, 10, 250, 100)
    End Sub
End Class
