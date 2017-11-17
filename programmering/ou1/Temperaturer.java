import java.util.*; // Scanner, Locale
class Temperaturer
{
	 public static void main (String[] args)
	 {
		System.out.println ("TEMPERATURER\n");

		// inmatningsverktyg
		Scanner in = new Scanner (System.in);
		in.useLocale (Locale.US);

		// mata in uppgifter om antalet veckor och antalet mätningar
		System.out.print ("antalet veckor: ");
		int antalVeckor = in.nextInt ();
		System.out.print ("antalet mätningar per vecka: ");
		int antalMatningarPerVecka = in.nextInt ();

		// plats att lagra temperaturer
		double[][] t = new double[antalVeckor + 1][antalMatningarPerVecka + 1];

		// mata in temperaturerna
		for (int vecka = 1; vecka <= antalVeckor; vecka++)
		{
		 System.out.println ("temperaturer - vecka " + vecka + ":");
		 for (int matning = 1; matning <= antalMatningarPerVecka; matning++)
			t[vecka][matning] = in.nextDouble ();
		}
		System.out.println ();

		// visa temperaturerna
		System.out.println ("temperaturerna:");
		for (int vecka = 1; vecka <= antalVeckor; vecka++)
		{
		 for (int matning = 1; matning <= antalMatningarPerVecka; matning++)
			System.out.print (t[vecka][matning] + " ");
		 System.out.println ();
		}
		System.out.println ();

		// den minsta, den största och medeltemperaturen – veckovis
		double[] minT = new double[antalVeckor + 1];
		double[] maxT = new double[antalVeckor + 1];
		double[] sumT = new double[antalVeckor + 1];
		double[] medelT = new double[antalVeckor + 1];

		for(int i = 1; i < t.length; i++){
			minT[i] = t[i][1];
			maxT[i] = minT[i];

			for(int j = 1; j < t[i].length; j++){
				if(t[i][j] > maxT[i]){
					maxT[i] = t[i][j];
				} else if(t[i][j] < minT[i]){
					minT[i] = t[i][j];
				}

				medelT[i] += t[i][j];
				sumT[i] += t[i][j];
			}

			medelT[i] = medelT[i]/(t[i].length - 1);
			System.out.println("Vecka " + i + " - Max: " + maxT[i] + ", Min: " + minT[i] + ", Medel: " + medelT[i] + ", Summa: " + sumT[i]);
		}

		double minTemp = minT[1];
		double maxTemp = maxT[1];
		double sumTemp = 0;
		double medelTemp = 0;

		for(int i = 1; i < t.length; i++){
			medelTemp += medelT[i];
			sumTemp += sumT[i];

			if (maxT[i] > maxTemp){
				maxTemp = maxT[i];
			} else if(minT[i] < minTemp){
				minTemp = minT[i];
			}

		}
		medelTemp = medelTemp/(medelT.length - 1);
		System.out.println("\nHela mätperioden - Max: " + maxTemp + ", Min: " + minTemp + ", Medel: " + medelTemp + ", Summa: " + sumTemp);
	  }
 }
