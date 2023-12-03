# History
### 참고 : http://naver.yojm.net/150146744487

## 히스토리 처리 개념.
  - 페이지의 이동이 있을경우 history가 쌓이게되고.
  - 앞으로 뒤로가기 기능을 통해 history페이지에 접근이 가능하다.
  - history 앞 뒤로 이동할경우, onload 이벤트가 발생한다.
      :> 이것을 이용하여 history 앞뒤로의 처리가 가능하다.

    ※ http://html5.clearboth.org/history.html

        window.history.length           :   병합 세션 히스토리의 항목들의 숫자를 반환합니다.
        window.history.go( [ delta ] )  :   병합 세션 히스토리에서 주어진 숫자만큼의 단계를 앞으로 가거나 뒤로 갑니다.
                                            0을 넘기면 현재 페이지를 리로드합니다.
                                            범위를 넘어가는 값을 넘기면, 아무 일도 일어나지 않습니다.
        window.history.back()           :   병합 세션 히스토리에서 한단계만큼 뒤로 갑니다.
                                            이전 페이지가 없다면, 아무 일도 일어나지 않습니다.
        window.history.forward()        :   병합 세션 히스토리에서 한단계만큼 앞으로 갑니다.
                                            다음 페이지가 없다면, 아무 일도 일어나지 않습니다.

        window.history.pushState(data, title [, url ] )
                                        :   주어진 타이틀로, 주어진 데이터를 세션 히스토리에 씁니다.
                                            URL이 주어졌다면 함께 적용합니다.

        window.history.replaceState(data, title [, url ] )
                                        :   주어진 타이틀과 데이터로 세션 히스토리의 현재 항목을 갱신합니다.
                                            URL이 주어졌다면 함께 적용합니다.

## 히스토리를 만드는 방법
  1. history.pushState
      : 페이지 리로드 없이 히스토리를 생성함.
      ▶ http://softm.net/test/history_20140507/history_using_pushState.html
      - window.history.pushState를 이용해 history.를 생성할 수있습니다.
        url을 지정하면 가상의 url로 페이지가 동작합니다.

      ▶ http://softm.net/test/history_20140507/history_using_pushState_1.html

  2. url을 변경.
      2.1. reload를 통한 url변경.
          ▶ http://softm.net/test/history_20140507/history_using_anchor_url1.html

      2.2. location.hash 를 변경하는 방법.
          2.2.1. document.location.hash = 'anchor_name1';
              ▶ http://softm.net/test/history_20140507/history_using_hash.html
          2.2.2. <a href="test.html#anchor_name1">
              ▶ http://softm.net/test/history_20140507/history_using_anchor_hash.html
