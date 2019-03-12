# interpreter.ex
defmodule Env do
  def new() do
    []
  end

  def add(id, str, env) do
    [{id,str} | env]
  end

  def lookup(id, env) do
    List.keyfind(env, id, 0, nil)
  end

  def remove([], env) do env end
  def remove([id | rest], env) do
    remove(rest, List.keydelete(env, id, 0))
  end
end

defmodule Eager do
  def eval_expr({:atm, id}, _) do {:ok, :a} end
  def eval_expr({:var, id}, env) do
    case Env.lookup(id, env) do
      nil ->
        :error
      {_, str} ->
        {:ok, str}
    end
  end
  def eval_expr({:cons, {x, y}, {a, b}}, env) do
    case eval_expr({x,y}, env) do
      :error ->
        :error
      {:ok, :a} ->
        case eval_expr({a,b}, env) do
          :error ->
            :error
          {:ok, ts} ->
            {ts, b}
        end
    end
  end

  def eval_match({:atm, :a}, :a, []) do {:ok, []} end
  def eval_match
end
