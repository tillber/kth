# mandelbrot.ex
defmodule Cmplx do
  def new(r, i) do
    {r, i}
  end

  def add({p, q}, {r, s}) do
    {p + r, q + s}
  end

  def sqr({a, b}) do
    {a*a - b*b, 2*a*b}
  end

  def abs({a, b}) do
    :math.sqrt(a*a + b*b)
  end
end

defmodule Color do
  def convert(d, m) do
    f = d/m
    a = f * 4
    x = Kernel.trunc(a)
    y = Kernel.trunc(255 * (a - x))

    case x do
      0 -> {:rgb, y, 0, 0}
      1 -> {:rgb, 255, y, 0}
      2 -> {:rgb,255 - y, 250, 0}
      3 -> {:rgb,0, 255, y}
      4 -> {:rgb,0, 255 - y, 255}
    end
  end
end

defmodule Mandel do
  def mandelbrot(width, height, x, y, k, depth) do
    trans = fn(w, h) ->
      Cmplx.new(x + k * (w - 1), y - k * (h - 1))
    end

    Mandel.rows(width, height, trans, depth, [])
  end

  def rows(_, 0, _, _, rows) do
    rows
  end
  def rows(w, h, t, d, rows) do
    row = Mandel.row(w, h, t, d, [])
    Mandel.rows(w, h - 1, t, d, [row | rows])
  end

  def row(0, _, _, _, row) do row end
  def row(w, h, t, d, row) do
    c = t.(w, h)
    a = Brot.mandelbrot(c, d)
    color = Color.convert(a, d)
    Mandel.row(w - 1, h, t, d, [color | row])
  end

  def demo() do
    small(-2.6, 1.2, 1.2)
  end

  def small(x0, y0, xn) do
    width = 960
    height = 540
    depth = 64
    k = (xn - x0) / width
    image = Mandel.mandelbrot(width, height, x0, y0, k, depth)
    PPM.write("small.ppm", image)
  end
end

defmodule Brot do
  def mandelbrot(c, m) do
    z0 = Cmplx.new(0, 0)
    i = 0
    test(i, z0, c, m)
  end

  def test(i, _, _, i) do
    0
  end
  def test(i, z, c, m) do
    if Cmplx.abs(z) > 2 do
      i
    else
      test(i + 1, Cmplx.add(Cmplx.sqr(z), c), c, m)
    end
  end
end
