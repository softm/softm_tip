package kr.co.gscaltex.gsnpoint.util;

/**
 * ��ȣȭ���� �� ����� ���߱� ���� ���Ǵ� <br>
 * Padding�� ������ Ŭ�����̴�.
 */
public class AnsiX923Padding implements CryptoPadding {

	/**
	 * �е� ��Ģ �̸�
	 */
	private String name = "ANSI-X.923-Padding";
	
	/**
	 * �е� byte ��
	 */
	private final byte PADDING_VALUE = 0x00;
	
	
	/* (non-Javadoc)
	 * @see com.palmia.mids.common.CryptoPadding#addPadding(byte[], int)
	 */
	/**
	 * ��û�� Block Size�� ���߱� ���� Padding�� �߰��Ѵ�.
	 * 
	 * @param source byte[] �е��� �߰��� bytes
	 * @param blockSize int block size
	 * @return byte[] �е��� �߰� �� ��� bytes
	 */
	public byte[] addPadding(byte[] source, int blockSize) {
		
		int paddingCnt = source.length % blockSize;
		byte[] paddingResult = null;
		
		if(paddingCnt != 0) {
			paddingResult = new byte[source.length + (blockSize - paddingCnt)];
			
			System.arraycopy(source, 0, paddingResult, 0, source.length);
			
			// �е��ؾ� �� ���� - 1 (�������� ����)���� 0x00 ���� �߰��Ѵ�.
			int addPaddingCnt = blockSize - paddingCnt;
			for(int i=0;i<addPaddingCnt;i++) {
				paddingResult[source.length + i] = PADDING_VALUE;
			}
			
			// ������ �е� ���� �е� �� Count�� �߰��Ѵ�.
			paddingResult[paddingResult.length - 1] = (byte)addPaddingCnt;
		} else {
			paddingResult = source;
		}

		return paddingResult;
	}

	/* (non-Javadoc)
	 * @see com.palmia.mids.common.CryptoPadding#removePadding(byte[], int)
	 */
	/**
	 * ��û�� Block Size�� ���߱� ���� �߰� �� Padding�� �����Ѵ�.<br>
	 * 
	 * @param source byte[] �е��� ������ bytes
	 * @param blockSize int block size
	 * @return byte[] �е��� ���� �� ��� bytes
	 */
	public byte[] removePadding(byte[] source, int blockSize) {
		
		byte[] paddingResult = null;
		boolean isPadding = true;
		
		// �е� �� count�� ã�´�.
		int lastValue = source[source.length - 1];
		if(0 < lastValue && lastValue < (blockSize - 1)) {
			int zeroPaddingCount = lastValue - 1;
			
			for(int i=2;i<(zeroPaddingCount + 2);i++) {
				if(source[source.length - i] != PADDING_VALUE) {
					isPadding = false;
					break;
				}
			}
		} else {
			// ������ ���� block size ���� Ŭ ��� �е� �Ȱ��� ����.
			isPadding = false;
		}
		
		if(isPadding) {
			paddingResult = new byte[source.length - lastValue];
			System.arraycopy(source, 0, paddingResult, 0, paddingResult.length);
		} else {
			paddingResult = source;
		}		
		
		return paddingResult;
	}

	/**
	 * �е� ��Ģ �̸��� �����Ѵ�.<br>
	 * 
	 * @return the name
	 */
	public String getName() {
		return name;
	}
}
