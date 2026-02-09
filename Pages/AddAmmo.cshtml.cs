using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;
using System.ComponentModel.DataAnnotations;

namespace Gunventory.Pages;

[Authorize]
public class AddAmmoModel : PageModel
{
    private readonly GunventoryContext _context;

    public AddAmmoModel(GunventoryContext context)
    {
        _context = context;
    }

    [BindProperty]
    public InputModel Input { get; set; } = new();

    public SelectList GunTypes { get; set; } = default!;
    public SelectList Calibers { get; set; } = default!;

    public class InputModel
    {
        [Required]
        [MaxLength(50)]
        public string Manufacturer { get; set; } = string.Empty;

        [Required]
        [Display(Name = "Gun Type")]
        public int GunTypeId { get; set; }

        [Required]
        [Display(Name = "Caliber")]
        public int CaliberId { get; set; }

        [Required]
        public int Rounds { get; set; }

        [Required]
        [DataType(DataType.Date)]
        public DateTime PurchaseDate { get; set; } = DateTime.Now;

        public decimal Price { get; set; }
    }

    public void OnGet()
    {
        GunTypes = new SelectList(_context.GunTypes.Where(t => t.Status == "A"), "Id", "Name");
        Calibers = new SelectList(_context.Calibers.Where(c => c.Status == "A"), "Id", "Name");
    }

    public async Task<IActionResult> OnPostAsync()
    {
        if (!ModelState.IsValid)
        {
            GunTypes = new SelectList(_context.GunTypes.Where(t => t.Status == "A"), "Id", "Name");
            Calibers = new SelectList(_context.Calibers.Where(c => c.Status == "A"), "Id", "Name");
            return Page();
        }

        var ammo = new Ammunition
        {
            Manufacturer = Input.Manufacturer,
            GunTypeId = Input.GunTypeId,
            CaliberId = Input.CaliberId,
            Rounds = Input.Rounds,
            PurchaseDate = Input.PurchaseDate,
            Price = Input.Price,
            Status = "A",
            STimestamp = DateTime.Now
        };

        _context.Ammunitions.Add(ammo);
        await _context.SaveChangesAsync();

        return RedirectToPage("/Index");
    }
}
