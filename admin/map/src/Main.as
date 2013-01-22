package
{
	import com.greensock.TweenLite;
	import flash.display.Bitmap;
	import flash.display.DisplayObjectContainer;
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.text.TextField;
	import flash.text.TextFormat;

	/**
	 * ...
	 * @author Stanislav
	 */
	public class Main extends Sprite
	{
		[Embed(source = '../lib/map.jpg')]
		private var map:Class;
		private var pointer:Sprite = new Sprite();
		private var my_window:Sprite = new Sprite();
		private var drag:Boolean;
		public function Main():void
		{
			if (stage) init();
			else addEventListener(Event.ADDED_TO_STAGE, init);
		}

		private function init(e:Event = null):void
		{
			removeEventListener(Event.ADDED_TO_STAGE, init);
			// entry point

			var my_map:Bitmap = new map() as Bitmap;
			var my_fon:Sprite = new Sprite();
			my_fon.addChild(my_map);
			addChild(my_fon);

			pointer.x = stage.stageWidth / 2;
			pointer.y = stage.stageHeight / 2;
			pointer.graphics.beginFill(0xc60000);
			pointer.graphics.drawCircle(0, 0, 3);
			addChild(pointer);
			
			pointer.buttonMode = true;
			my_fon.addEventListener(MouseEvent.CLICK, move_point);
			pointer.addEventListener(MouseEvent.MOUSE_DOWN, start_drag);
			stage.addEventListener(MouseEvent.MOUSE_UP, stop_drag);
			generate_button();
		}

		private function stop_drag(e:MouseEvent):void
		{
			if (drag)
			{
				drag = false;
				pointer.stopDrag();
			}
		}

		private function start_drag(e:MouseEvent):void
		{
			drag = true;
			pointer.startDrag();
		}

		private function generate_button():void
		{
			var my_button:Sprite = new Sprite();
			my_button.graphics.beginFill(0xFFFFFF, .7);
			my_button.graphics.drawRect( 0, 0, 60, 20);

			my_button.x = 370;
			my_button.y = 5;

			var my_text:TextField = new TextField();
			var my_format:TextFormat = new TextFormat("Arial", 12, 0x0d4b94);
			my_text.text = "Press me";

			my_text.setTextFormat(my_format);
			my_text.height = my_text.textHeight + 2;
			my_text.width = my_text.textWidth + 4;
			my_text.selectable = false;
			my_button.addChild(my_text);

			addChild(my_button);
			addChild(my_window);
			my_button.addEventListener(MouseEvent.CLICK, trace_cors);
		}

		private function trace_cors(e:MouseEvent):void
		{
			close_window();

			my_window.graphics.beginFill(0xFFFFFF, .7);
			my_window.graphics.drawRect(0, 0, 150, 50);
			my_window.x = stage.stageWidth / 2 - my_window.width / 2;
			my_window.y = stage.stageHeight / 2 - my_window.height / 2;

			var my_text:TextField = new TextField();
			var my_format:TextFormat = new TextFormat("Arial", 12, 0x0d4b94);
			my_text.multiline = true;
			my_text.wordWrap = true;
			my_text.htmlText = "X="+pointer.x+" Y="+pointer.y;
			my_text.width = 150;
			my_text.height = 30;
			my_text.setTextFormat(my_format);

			my_window.addChild(my_text);

			var my_close_button:Sprite = new Sprite();
			var my_close_text:TextField = new TextField();
			var my_close_format:TextFormat = new TextFormat("Arial", 16, 0x0d4b94);
			my_close_text.text = "CLOSE";

			my_close_text.selectable = false;
			my_close_text.setTextFormat(my_close_format);
			my_close_text.height = my_close_text.textHeight + 2;
			my_close_text.width = my_close_text.textWidth + 4;

			my_close_button.addChild(my_close_text);
			my_close_button.x = my_window.width / 2 - my_close_button.width / 2;
			my_close_button.y = 50 - my_close_button.height;
			my_window.addChild(my_close_button);

			my_close_button.addEventListener(MouseEvent.CLICK, close_window);

		}

		private function close_window(e:MouseEvent=null):void
		{
			clearDOC(my_window);
			my_window.graphics.clear();
		}

		private function move_point(e:MouseEvent):void
		{
			TweenLite.to(pointer, .2, { x:mouseX, y:mouseY });
		}

		private function clearDOC($DOC:DisplayObjectContainer):void
		{
			while ($DOC.numChildren) $DOC.removeChildAt(0);
		}

	}

}

