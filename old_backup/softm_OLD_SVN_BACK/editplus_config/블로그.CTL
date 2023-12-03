#TITLE=블로그
#INFO
New Cliptext library
#SORT=n

#T=highlight.js
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/styles/railscasts.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/highlight.min.js"></script>

<script>hljs.initHighlightingOnLoad();</script>
<pre><code class="java">

package net.softm.test;
import java.util.Random;
public class RandomTest {
    public static void main(String[] args) throws Exception {
        exec();
    }

    public static String exec() {
        String rtn = "";
        Random randomGenerator      = new Random();
        int     randomInteger       = randomGenerator.nextInt(100);     // 0 ~ 99 사이의 int를 랜덤으로 생성
        int     randomIntegerUniform= randomGenerator.nextInt();        // int를 랜덤으로 생성
        long    randomLongUniform   = randomGenerator.nextLong();       // long을 랜덤으로 생성
        double  randomDouble        = randomGenerator.nextDouble();     // 0.0 ~ 1.0 사이의 double을 랜덤으로 생성 (1.0은 안나옴)
        float   randomDouble1       = randomGenerator.nextFloat();      // 0.0 ~ 1.0 사이의 float를 랜덤으로 생성 (1.0은 안나옴)
        boolean randomBoolean       = randomGenerator.nextBoolean();    // true, false를 랜덤으로 생성
        double  randomGaussianDouble=  randomGenerator.nextGaussian();  // 평균 0, 표준편차1의 분포에 따른 랜덤 double 생성
        byte[]  randomBytes = new byte[10];
        randomGenerator.nextBytes(randomBytes); //randomBytes의 크기만큼 랜덤 바이트를 생성
        int start = 5;
        int end = 10;
        double range = end - start + 1;
        int randomInt5to10 = (int)(randomGenerator.nextDouble() * range + start);
        System.out.println("randomInteger        : " + randomInteger       );
        System.out.println("randomIntegerUniform : " + randomIntegerUniform);
        System.out.println("randomLongUniform    : " + randomLongUniform   );
        System.out.println("randomDouble         : " + randomDouble        );
        System.out.println("randomDouble1        : " + randomDouble1       );
        System.out.println("randomBoolean        : " + randomBoolean       );
        System.out.println("randomGaussianDouble : " + randomGaussianDouble);
        System.out.println("randomInt5to10       : " + randomInt5to10      );
        return rtn;
    }
}
</code></pre>

#T=ㄴㄴ
<link rel="stylesheet" href="/path/to/styles/default.css">
<script src="/path/to/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
#