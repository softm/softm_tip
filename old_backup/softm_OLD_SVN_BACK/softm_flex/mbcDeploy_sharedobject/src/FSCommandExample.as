package {
    import flash.display.Sprite;
    import flash.text.TextField;
    import flash.system.fscommand;
    import flash.events.MouseEvent;
		
    public class FSCommandExample extends Sprite {
        private var bgColor:uint = 0xFFCC00;
        private var size:uint = 100;

        public function FSCommandExample() {
            fscommand("fullscreen", "true");
            fscommand("allowscale", "false");
            draw();
        }

        private function clickHandler(event:MouseEvent):void {
            fscommand("quit");
            trace("clickHandler");
        }

        private function draw():void {
            var child:Sprite = new Sprite();
            child.graphics.beginFill(bgColor);
            child.graphics.drawRect(0, 0, size, size);
            child.graphics.endFill();
            child.buttonMode = true;
            addEventListener(MouseEvent.CLICK, clickHandler);

            var label:TextField = new TextField();

/*
			var fileName:File = new File(); 
				fileName.nativePath = "C:/test.txt"; 
				trace(fileName.exists);
*/
            label.text = "quit";
            label.selectable = false;
            label.mouseEnabled = false;
            child.addChild(label);

            addChild(child);
        }
    }
}
